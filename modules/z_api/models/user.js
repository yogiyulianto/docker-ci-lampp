//use mysql database
const con = require('../../../config/db.config');

module.exports = {
    getLastId: function(callback) {
        con.query(
          `SELECT SUBSTRING(user_id, 8) AS 'first_number' FROM com_user ORDER BY user_id DESC LIMIT 1`,callback
          // `SELECT user_id AS 'first_number' FROM com_user ORDER BY user_id DESC LIMIT 1`,callback
        )
      },

    createUser: function(data, callback) {
      console.log(data)
      sql = `INSERT INTO com_user SET ?`;
      con.query(sql, data, callback)
    },

    getByUsername: function(params, callback) {
      sql = `SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role b ON b.role_id = a.role_id WHERE a.username = ? LIMIT 1`
      con.query(sql, params, callback)
    },

  }