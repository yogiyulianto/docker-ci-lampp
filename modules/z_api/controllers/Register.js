'use strict';
const bcrypt = require('bcrypt');
const path = require('path')
const jwt = require('jsonwebtoken');
require('dotenv/config');

// import file
const basemailer = require('./../../../config/mail');
const helper_ext = require('./../../../config/helper_ext');

// import model
const _MUser = require("./../../z_admin/models/user")
const _Mlogin = require("./../../z_sistem/models/login")

exports.process = function (req, res) {

    var nama_lengkap = req.body.nama_lengkap;
    var email = req.body.email;
    var password = req.body.user_pass;
    var password_konfirmasi = req.body.user_pass_konfirmasi;

    // cek pass
    if (password && password_konfirmasi) {
        if (password != password_konfirmasi) {
            res.status(200).json({ notif_st: false, notif_msg: "Password konfirmasi tidak sesuai !" }); res.end(); return false;
        }
    } else {
        res.status(200).json({ notif_st: false, notif_msg: "Password atau password konfirmasi tidak boleh kosong !" }); res.end(); return false;
    }
    if (!nama_lengkap || !email) {
        res.status(200).json({ notif_st: false, notif_msg: "Data tidak lengkap !" }); res.end(); return false;
    }

    // cek email terdaftar
    _Mlogin.getExistEmail(email, function (err, rows) {
        if (err) throw err
        if (rows[0]) {
            res.status(200).json({ notif_st: false, notif_msg: "Email sudah terdaftar, gunakan email lain atau lakukan fitur lupa password !" }); res.end(); return false;
        } else {

            // 
            var number;
            var user_id;
            var dateObj = new Date();
            var month = helper_ext.getMonth2d(dateObj); //months from 01-12
            var day = helper_ext.getDate2d(dateObj);
            var year = dateObj.getUTCFullYear();
            //buat prefix
            var prefix = year + "" + month + "" + day;
            var aktifasi_number = helper_ext.generatechar(20);

            // get last_id
            _MUser.getLastId(function (err, rows) {
                // jika error
                if (err) {
                    console.log(err)
                } else if (!rows[0]) {
                    user_id = prefix + '1';
                } else if (!rows[0].first_number) {
                    user_id = prefix + '1';
                } else if (rows[0].first_number) {
                    number = parseInt(rows[0]['first_number']) + 1;
                    user_id = prefix + number;
                }

                // cek email terdaftar
                _MUser.getExistEmail(email, function (err, rows) {
                    if (err) throw err

                    if (rows[0]) {
                        res.cookie("st_process", "Gagal"); res.cookie("notif", "Email telah terdaftar, gunakan email lain !"); res.redirect('/admin/add_admin');
                    } else {
                        const saltRounds = 10;
                        // hash pass
                        bcrypt.hash(password, saltRounds, function (err, hash) {

                            // create token
                            var token_key = helper_ext.generatechar(6);
                            var token = jwt.sign({
                                id: user_id
                            }, token_key, {
                                expiresIn: 99999999999999999999999999999999999999999 //24h expired
                            });
                            
                            //insert ke com_user
                            var params_com_user = {
                                user_id: user_id,
                                role_id: 2,
                                nama: nama_lengkap,
                                email: email,
                                password: hash,
                                aktifasi_number: aktifasi_number,
                                token_key: token_key,
                                token: token,
                                user_st: '0',

                            };
                            //   insert com_user
                            _MUser.createUser(params_com_user, function (err) {
                                if (err) throw err
                                // konfig email
                                var mailOptions = {
                                    from: basemailer.sender,
                                    to: email,
                                    subject: 'Registrasi akun Aplikasi ' + process.env.APP_NAME,
                                    html: 'Selamat anda berhasil mendaftar <b> Aplikasi ' + process.env.APP_NAME + ' </b> sebagai <b>User</b>. <p> Klik link berikut untuk verifikasi akun : <a href="' + process.env.APP_URL + '/aktifasi?kode=' + aktifasi_number + '">Aktifasi Akun</a>'
                                };

                                // sendmail
                                basemailer.transporter.sendMail(mailOptions, function (error, info) {
                                    if (error) {
                                        console.log(error);
                                        //Gagal
                                        res.cookie("st_process", "Gagal"); res.cookie("notif", "User berhasil terdaftar, tapi email tidak dapat dikirim, hubungi admin untuk aktifasi."); res.redirect('/admin/add_admin');
                                    } else {
                                        console.log('Email sent: ' + info.response);
                                        //Sukses
                                        res.cookie("st_process", "Sukses"); res.cookie("notif", "User berhasil terdaftar, cek email anda untuk aktifasi."); res.redirect('/admin/add_admin');
                                    }
                                })
                            })
                        });
                    }
                });
            })
            // konfig email
            var mailOptions = {
                from: basemailer.sender,
                to: email,
                subject: 'Registrasi Akun ' + process.env.APP_NAME,
                html: 'Selamat anda berhasil mendaftar <b> Aplikasi Member ' + process.env.APP_NAME + ' </b>. <p> Klik link berikut untuk verifikasi akun : <a href="' + process.env.APP_URL + 'aktifasi?kode=' + aktifasi_number + '">Aktifasi Akun</a>'
            };

            // sendmail
            basemailer.transporter.sendMail(mailOptions, function (error, info) {
                if (error) {
                    console.log(error);
                    res.status(200).json({ notif_st: false, notif_msg: "Email tidak dapat dikirim karena jaringan tidak stabil !" }); res.end();
                } else {
                    console.log('Email sent: ' + info.response);
                    //Sukses
                    res.status(200).json({ notif_st: true, notif_msg: "Anda berhasil mendaftar, silahkan cek email untuk verifikasi akun." }); res.end();
                }
            })
        }
    })


};
