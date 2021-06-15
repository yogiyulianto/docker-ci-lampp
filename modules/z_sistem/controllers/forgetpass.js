'use strict';
const bcrypt = require('bcrypt');
var path = require('path')

const basemailer = require('./../../../config/mail');
const helper_ext = require('./../../../config/helper_ext');


// import model
const _MUser = require("./../../z_admin/models/user")

exports.index = function(req, res) {
    //cek login
    if (req.session.loggedin) {
            res.redirect('/');        
    }else{
        //notif
        var st_process = req.cookies["st_process"];
        res.clearCookie("st_process");
        var notif = req.cookies["notif"];
        res.clearCookie("notif");

        res.render(path.join(__dirname, '../views/forgetpass'), {
            title     : 'Lupa Password',
            menu      : req.originalUrl,
            st        : st_process,
            notif     : notif,
            });
    }
};

exports.process = function(req, res) {
      //cek login
        if (req.session.loggedin) {
            res.redirect('/');
        }else{
            var user_mail           = req.body.user_mail;
            // validasi email
            if (!user_mail) {
                res.cookie("st_process", "Gagal");
                res.cookie("notif", "Email harus diisi !");
                res.redirect('/forgetpass');
            } else {

                _MUser.getByEmail(user_mail, function(err, rows) {
                    if (err) throw err
                    
                    if (rows[0]) {
                         // password baru 
                        var pass = helper_ext.generatechar(5);
                        const saltRounds = 10;
                        //decrypt pass
                        bcrypt.hash(pass, saltRounds, function(err, hash) {
                            var params = [hash, user_mail];

                            _MUser.updatePassUser(params, function(err) {
                                if(err) throw err

                                // konfig email
                                var mailOptions = {
                                    from: basemailer.sender,
                                    to: user_mail,
                                    subject: 'Reset Password Akun Member BPR Adipura',
                                    html: 'Password akun anda telah direset, gunakan password tersebut untuk login ke dalam <b> Aplikasi Member Merchant BPR Adipura </b>. <p> Password Baru :<b> '+pass+' </b>'
                                };

                                // sendmail
                                basemailer.transporter.sendMail(mailOptions, function(error, info){
                                    if (error) {
                                        console.log(error);
                                        res.end()
                                    } else {
                                        console.log('Email sent: ' + info.response);
                                        //Sukses
                                        res.cookie("st_process", "Sukses");
                                        res.cookie("notif", "Password baru anda telah dikirimkan ke email.");
                                        res.redirect('/login');
                                    }
                                })
                            });
                        });
                    }else{
                        res.cookie("st_process", "Gagal");
                        res.cookie("notif", "Email tidak ditemukan !");
                        res.redirect('/forgetpass');
                    }
                });
            }
        }
}


exports.verifikasi_process = function(req, res) {
    //cek login
      if (req.session.loggedin) {
          res.redirect('/');
      }else{
          _MUser.updateAktifasi(req.query.kode, function(err) {
            //Sukses
            res.cookie("st_process", "Sukses");
            res.cookie("notif", "Akun telah berhasil diaktifasi, anda dapat login kedalam aplikasi.");
            res.redirect('/login');
        });
      }
}

