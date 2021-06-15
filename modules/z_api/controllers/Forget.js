'use strict';
const bcrypt = require('bcrypt');
var path = require('path')

const basemailer = require('./../../../config/mail');
const helper_ext = require('./../../../config/helper_ext');


// import model
const _MUser = require("./../../z_admin/models/user")

module.exports = {
    process: function(req, res){
        var user_mail           = req.body.user_mail;
            // validasi email
            if (!user_mail) {
                res.status(200).json({ notif_st: false, notif_msg: "Email haris diisi !"}); res.end();
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
                                        res.status(200).json({ notif_st: true, notif_msg: "Password baru anda telah dikirimkan ke email."}); res.end();
                                    }
                                })
                            });
                        });
                    }else{
                        res.status(200).json({ notif_st: false, notif_msg: "Email tidak ditemukan !"}); res.end();
                    }
                });
            }
    },
}
