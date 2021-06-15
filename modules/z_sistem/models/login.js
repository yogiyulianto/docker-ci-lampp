//use mysql database
const con = require('./../../../config/db.config');

module.exports = {
    // get: function(con, callback) {
    //   con.query("SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role b ON b.role_id = a.role_id WHERE a.username = ? LIMIT 1", callback)
    // },

    getByEmail: function(params, callback) {
        sql = `SELECT a.* FROM com_user a WHERE a.email = ? LIMIT 1`;
        con.query(sql, params, callback)
    },
  
    getExistEmail: function(params, callback) {
        sql =`SELECT a.* FROM com_user a WHERE a.email = ? LIMIT 1`;
        con.query(sql, params, callback)
    },

    getChekRegister: function(params, callback) {
        sql =`SELECT a.user_id, a.no_hp, b.nama_lengkap, b.tanggal_lahir, a.token FROM com_user a INNER JOIN user b ON a.user_id = b.user_id INNER JOIN com_role_user c ON c.user_id = a.user_id WHERE b.nama_lengkap = ? AND a.no_hp = ? AND b.tanggal_lahir = ? AND c.role_id = 3 LIMIT 1`;
        con.query(sql, params, callback)
    },
  
    getExistHp: function(params, callback) {
        sql = `SELECT a.* FROM com_user a WHERE a.no_hp = ? LIMIT 1`;
        con.query(sql, params, callback)
    },

    getByHpLogin: function(params, callback) {
      sql = `SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role_user b ON b.user_id = a.user_id WHERE a.no_hp =  ? LIMIT 1`
      con.query(sql, params, callback)
    },

  }