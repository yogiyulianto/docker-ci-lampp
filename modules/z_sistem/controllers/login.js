'use strict';
const bcrypt = require('bcrypt');
var path = require('path')
var captchapng = require('captchapng');

// 
var global = require("./../../../config/global_var");

// import model
const _Mlogin = require("./../../z_sistem/models/login")

module.exports = {
    index: function(req, res){
        //notif
        var st_process = req.cookies["st_process"];
        res.clearCookie("st_process");
        var notif = req.cookies["notif"];
        res.clearCookie("notif");

        //cek login
        if (req.session.loggedin) {
            // validasi redirect sesuai role
            res.redirect('/');   
        }else{
            // cretae captcha
            var code = parseInt(Math.random() * 9000 + 1000);
            req.session.captcha = code;//Saved in the session to facilitate the verification code judgment later
            var p = new captchapng(100, 30, code);
            p.color(0, 0, 0, 0);
            p.color(80, 80, 80, 255);
            var img = p.getBase64();
            var imgbase64 = new Buffer.from(img,'base64');
   
            var valicode = new Buffer.from(imgbase64).toString('base64');       

            res.render(path.join(__dirname, '../views/login'), {
                valicode   : valicode,
                title     : 'Login',
                st        : st_process,
                notif     : notif,
            });  
        }
    },
    process: function(req, res){
            //cek login
            if (req.session.loggedin) {
                    res.redirect('/');
            }else{
                var captcha = req.body.captcha;   
                // cek captcha
                if (!captcha) {
                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Captcha harus diisi !"); res.redirect('/login'); return false;
                }
                else if (captcha !== req.session.captcha.toString()){
                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Captcha tidak sesuai !"); res.redirect('/login'); return false;
                }

                // res.send('hallo');
                var email = req.body.user_mail;
                var password = req.body.user_pass;

                if (email && password) {
                    _Mlogin.getByEmail(email, function(err, rows) {
                        if (err) throw err

                        if (rows[0]) {
                            // //encrypt password
                            bcrypt.compare(password, rows[0]['password'], function(err, result_hash) {
                                //   //passwod salah
                                if (result_hash == true) {
                                    //cek stathallous user
                                    if(rows[0]['user_st'] == 'tidak_aktif') {
                                        res.cookie("st_process", "Gagal"); res.cookie("notif", "Akun anda belum di aktifasi, silahkan cek email anda untuk mengaktifkan akun."); res.redirect('/login');
                                    }else if(rows[0]['user_st'] == 'blok') {
                                        res.cookie("st_process", "Gagal"); res.cookie("notif", "Akun anda telah di blok, silahkan hubungi admin untuk konfirmasi."); res.redirect('/login');
                                    }else if(rows[0]['role_id'] != 1){
                                        res.cookie("st_process", "Gagal"); res.cookie("notif", "Hanya admin yang berhak mengakses website ini !"); res.redirect('/login');
                                    }else{
                                        //sukses login set session
                                        req.session.loggedin    = true;
                                        req.session.user_id     = rows[0]['user_id'];
                                        req.session.nama        = rows[0]['nama_lengkap'];
                                        req.session.role_id     = rows[0]['role_id'];
                                        req.session.email       = rows[0]['user_mail'];
                                        res.redirect('/');
                                    }
                                }else{
                                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Password salah !"); res.redirect('/login');
                                }
                            });
                                
                        }else{
                            res.cookie("st_process", "Gagal"); res.cookie("notif", "Email tidak ditemukan !"); res.redirect('/login');
                        }
                    })
                }else{
                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Email dan password tidak boleh kosong !"); res.redirect('/login');
                }
            }
    
        // })
    },
}
