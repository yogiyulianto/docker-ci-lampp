'use strict';
const bcrypt = require('bcrypt');
const e = require('express');
var path = require('path')
var global = require("../../../config/global_var");

// import model
const _Mlogin = require("../../z_sistem/models/login")

module.exports = {
    process: function(req, res){
        var email = req.body.user_mail;
        var password = req.body.user_pass;

        //cek login
        if (email && password) {

            //cek data login
            _Mlogin.getByEmail(email, function(err, rows) {
                if (err) throw err
                console.log(rows[0]['role_id'] == 1);
                if (rows) {
                    bcrypt.compare(password, rows[0]['password'], function(err, result_hash) {
                        if (result_hash == true) {
                            //cek role
                            if(rows[0]['role_id'] == 1) {
                                res.status(200).json({ notif_st: false, notif_msg: "Role anda tidak berhak mengakses aplikasi ini !"});
                                res.end();return false;
                            }
                            //cek stathallous user
                            if(rows[0]['user_st'] == 0) {
                                res.status(200).json({ notif_st: false, notif_msg: "Akun belum diaktifasi, cek email untuk aktifasi akun !"});
                                res.end();res.end();return false;
                            }else if(rows[0]['user_st'] == 2) {
                                res.status(200).json({ notif_st: false, notif_msg: "Akun telah di blok, hubungi admin untuk membuka blokir !"});
                                res.end();res.end();return false;
                            }else{

                                var data = {'user_id': rows[0]['user_id'],'nama':rows[0]['nama'],'role_id': rows[0]['role_id'], 'token_key':rows[0]['token_key'], 'token': rows[0]['token']};
                                res.status(200).json({ notif_st: true, notif_msg: "Berhasil login.", data_login : data})
                                res.end();
                            }
                        }else{
                            res.status(200).json({ notif_st: false, notif_msg: "Password salah !"});
                            res.end();res.end();return false;
                        }
                    });
                }else{
                    res.status(200).json({ notif_st: false, notif_msg: "Email tidak terdaftar !"});
                    res.end();return false;
                }
            });
        }else{
            res.status(200).json({ notif_st: false, notif_msg: "Email atau password tidak boleh kosong !"});
            res.end();return false;
        }
    },
}
