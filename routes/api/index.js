const express = require('express');
const router = express.Router();

const _Clogin = require('../../modules/z_api/controllers/Login');
const _Cregister = require('../../modules/z_api/controllers/Register');
const _Cforgetpass = require('../../modules/z_api/controllers/Forget');
const _Clandingpage = require('../../modules/z_api/controllers/Landing');
const _CAkun = require('../../modules/z_api/controllers/Account');

/* Login. */
router.route('/api/login').post(_Clogin.process);

/* Register. */
router.route('/api/register').post(_Cregister.process);

/* Forget Password. */
router.route('/api/forgetpass').post(_Cforgetpass.process);

/* Landingpage. */
router.route('/api/landingpage').get(_Clandingpage.index);

/* Profile. */
router.route('/api/myprofile').get(_CAkun.myprofile);

module.exports = router;
