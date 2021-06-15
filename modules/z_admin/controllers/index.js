// const Data = require('../../z_admin/models/')
// var global = require('./../../../config/global_var')
var path = require('path');

// let Data = [
//     {id: 1, name: 'Rahmadz', email: 'rahmadz@gmail.com'},
//     {id: 2, name: 'Fery', email: 'rahmadz1@gmail.com'}
// ]

module.exports = {
  index: function (req, res) {
    //cek login
    if (req.session.loggedin) {
      var data_login = {
        user_id: req.session.user_id,
        nama: req.session.nama,
        role_id: req.session.role_id,
        email: req.session.email,
      };

      // validasi redirect sesuai role
      res.render(path.join(__dirname, '../views/index'), {
        title: 'Dashboard',
        dataLogin: data_login,
      });
    } else {
      //Sukses
      res.cookie('st_process', 'Gagal');
      res.cookie(
        'notif',
        'Anda belum login, silahkan login untuk mengakses website admin.'
      );
      res.redirect('/login');
    }
  },
};
