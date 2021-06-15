'use strict';
const { UpgradeRequired } = require('http-errors');
const path = require('path')
const jwt = require('jsonwebtoken');

const helper_ext = require('../../../config/helper_ext');

// import model
const _MUser = require("../../z_admin/models/user")

module.exports = {
    myprofile: function (req, res, next) {

        var user_id = req.query.user_id;
        var token = req.query.token;
        var token_key = req.query.token_key;

        if (!req.query) {
            res.status(200).json({ notif_st: false, notif_msg: "Data tidak lengkap !" }); res.end();
        } else {

            jwt.verify(token, token_key, function (err, decoded) {
                if (err) throw err
                if (err) {
                    return res.status(200).json({ notif_st: false, notif_msg: "JWT Expired atau token salah !"}); 
                }

                _MUser.getUserByID(user_id,function (err, rowuser) {
                    if (err) throw err
                    return res.status(200).json({ notif_st: true, notif_msg: "Berhasil.", dataMember:rowuser[0]  }); res.end();
                });
            });
        }
    },
}
