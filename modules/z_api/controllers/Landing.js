'use strict';
const { UpgradeRequired } = require('http-errors');
const path = require('path')
const jwt = require('jsonwebtoken');

const helper_ext = require('../../../config/helper_ext');


// import model
const _MUser = require("../../z_admin/models/user")

module.exports = {
    index: function (req, res, next) {

        var user_id = req.query.user_id;
        var token = req.query.token;
        var token_key = req.query.token_key;
        var role_id = req.query.role_id;

        // validasi email
        if (user_id && token && token_key && role_id) {
            // verify a token symmetric
            jwt.verify(token, token_key, function (err, decoded) {
                // if (err) throw err
                if (err) {
                    return res.status(200).json({ notif_st: false, notif_msg: "Token Expired atau token salah !"}); 
                }

                _MUser.getUserByIDDispay(user_id,function (err, rowuser) {
                    if (err) throw err
                });
            });
        } else {
            res.status(200).json({ notif_st: false, notif_msg: "Data tidak lengkap !" }); res.end();
        }
    },
}
