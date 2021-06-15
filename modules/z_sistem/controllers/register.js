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
const _Mlogin = require("./../../z_sistem/models/login");

exports.index = function (req, res) {
    //cek login
    if (req.session.loggedin) {
        res.redirect('/');
    } else {
        //notif
        var st_process = req.cookies["st_process"];
        res.clearCookie("st_process");
        var notif = req.cookies["notif"];
        res.clearCookie("notif");

        res.render(path.join(__dirname, '../views/register'), {
            title: 'Daftar',
            menu: req.originalUrl,
            st: st_process,
            notif: notif,
        });
    }
};


exports.process = function (req, res, next) {

    //cek login
    if (req.session.loggedin) {
        res.redirect('/admin');
    } else {
        var nama_lengkap = req.body.nama_lengkap;
        var no_hp = req.body.no_hp;
        var tgl_lahir = req.body.tanggal_lahir;
        var user_mail = req.body.user_mail;
        var password = req.body.user_pass;
        var password_konfirmasi = req.body.user_pass_konfirmasi;

        // cek pass
        if (password || password_konfirmasi) {
            if (password != password_konfirmasi) {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Password konfirmasi tidak sesuai"); res.redirect('/register');
            }
        }else{
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Password atau password konfirmasi tidak boleh kosong !"); res.redirect('/register');
        }

        if ( !nama_lengkap || !no_hp || !tgl_lahir || !user_mail) {
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak lengkap !"); res.redirect('/register');
        }

        var params_cek = [nama_lengkap, no_hp, tgl_lahir];

        // cek email terdaftar
        _Mlogin.getChekRegister(params_cek, function (err, rows) {
            if (err) throw err

            if (rows[0]) {

                if (rows[0].token) {
                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda telah terdaftar sebelumnya, silahkan pilih fitur lupa password jika anda lupa password anda !"); res.redirect('/register');
                }

                var user_id = rows[0].user_id;
                    const saltRounds = 10;
                    var aktifasi_number = helper_ext.generatechar(20);
                    //decrypt pass
                    bcrypt.hash(password, saltRounds, function (err, hash) {

                        // create token
                        var token_key = helper_ext.generatechar(6);
                        var token = jwt.sign({
                            id: user_id
                        }, token_key, {
                            expiresIn: 99999999999999999999999999999999999999999 //24h expired
                        });

                        //update ke com_user
                        var params_user = [hash, token, token_key, aktifasi_number, user_id];
                        //   insert com_user
                        _MUser.UpdateRegister(params_user, function (err) {
                            if (err) throw err
                            // konfig email
                            var mailOptions = {
                                from: basemailer.sender,
                                to: user_mail,
                                subject: 'Registrasi Akun Member ' + process.env.APP_NAME,
                                html: 'Selamat anda berhasil mendaftar <b> Aplikasi Member Merchant ' + process.env.APP_NAME + ' </b>. <p> Klik link berikut untuk verifikasi akun : <a href="' + process.env.APP_URL + '/aktifasi?kode=' + aktifasi_number + '">Aktifasi Akun</a>'
                            };

                            // sendmail
                            basemailer.transporter.sendMail(mailOptions, function (error, info) {
                                if (error) {
                                    console.log(error);

                                    res.cookie("st_process", "Sukses"); res.cookie("notif", "Email tidak dapat dikirim karena jaringan tidak stabil !"); res.redirect('/register');
                                } else {
                                    console.log('Email sent: ' + info.response);
                                    //Sukses
                                    res.cookie("st_process", "Sukses"); res.cookie("notif", "Anda berhasil mendaftar, silahkan cek email untuk verifikasi akun."); res.redirect('/login');
                                }
                            })
                        })

                    });
            } else {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak cocok dengan master data, register gagal !"); res.redirect('/register');
            }
        })
    }
};
