'use strict';
// library
const jwt = require('jsonwebtoken');
const global = require('../config/global_var');

// export
exports.generatechar = function (length) {
  var result = '';
  var characters =
    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
};

exports.getDate2d = function (date) {
  var month = date.getDate();
  return month < 10 ? '0' + month : '' + month; // ('' + month) for string result
};

exports.getMonth2d = function (date) {
  var month = date.getMonth() + 1;
  return month < 10 ? '0' + month : '' + month; // ('' + month) for string result
};
