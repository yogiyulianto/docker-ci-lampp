//use mysql database
const con = require('./../../../config/db.config');

module.exports = {
    // get: function(con, callback) {
    //   con.query("SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role b ON b.role_id = a.role_id WHERE a.username = ? LIMIT 1", callback)
    // },

    getByEmail: function(params, callback) {
        con.query(`SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role_user b ON b.user_id = a.user_id WHERE a.user_mail = '${params}' LIMIT 1`, callback)
    },
  
    getExistEmail: function(params, callback) {
        var sql =`SELECT a.* FROM com_user a WHERE a.user_mail = ? LIMIT 1`;
        con.query(sql, params, callback)
    },
  
  }