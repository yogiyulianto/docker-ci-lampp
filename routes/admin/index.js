const express = require('express');
const router = express.Router();

const _CDashboard = require('../../modules/z_admin/controllers/index');
const _CUser = require('../../modules/z_admin/controllers/user');

// Dashboard Router
router.route('/').get(_CDashboard.index);

// Master User Router
router.route('/admin/user').get(_CUser.index);
router.route('/admin/get_list_user').get(_CUser.get_list_user);
// admin
router.route('/admin/add_admin').get(_CUser.add_admin);
router.route('/admin/add_admin').post(_CUser.add_admin_process);
router.route('/admin/edit_user').get(_CUser.edit_user);
router.route('/admin/edit_user').post(_CUser.edit_user_process);
// member
router.route('/admin/add_member').get(_CUser.add_member);
router.route('/admin/add_member').post(_CUser.add_member_process);
router.route('/admin/user_delete').delete(_CUser.delete_process);

module.exports = router;
