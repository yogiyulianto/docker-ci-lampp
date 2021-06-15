'use strict';
require('dotenv/config');
var nodemailer = require('nodemailer');

var sender = process.env.MAIL_SENDER;
//config email
exports.sender = sender;

//config email
exports.transporter = nodemailer.createTransport({
  service: process.env.MAIL_SERVICE,
  host: process.env.MAIL_HOST,
  auth: {
    user: process.env.MAIL_USERNAME,
    pass: process.env.MAIL_PASSWORD,
  },
});
