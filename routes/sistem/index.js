var express = require('express');
var router = express.Router();
// import controller
var _Clogin = require('./../../modules/z_sistem/controllers/login');
var _Clogout = require('../../modules/z_sistem/controllers/logout');
var _CRegister = require('./../../modules/z_sistem/controllers/register');
var _CForgetpass = require('./../../modules/z_sistem/controllers/forgetpass');

/* Login. */
router.route('/login').get(_Clogin.index);
router.route('/login').post(_Clogin.process);

/* Logout. */
router.route('/logout').get(_Clogout.process);
router.route('/admin/logout').get(_Clogout.process);

/* Register. */
router.route('/register').get(_CRegister.index);
router.route('/register').post(_CRegister.process);

/* Forget Password. */
router.route('/forgetpass').get(_CForgetpass.index);
router.route('/forgetpass').post(_CForgetpass.process);
router.route('/aktifasi').post(_CForgetpass.verifikasi_process);

module.exports = router;
