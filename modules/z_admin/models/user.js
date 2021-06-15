//use mysql database
// const { param } = require('../../../routes/admin');
const con = require('./../../../config/db.config');

module.exports = {
  getLastId: function (callback) {
    con.query(
      `SELECT SUBSTRING(user_id, 9) AS 'first_number' FROM com_user ORDER BY user_id DESC LIMIT 1`,
      callback
    );
  },

  createUser: function (data, callback) {
    sql = `INSERT INTO com_user SET ?`;
    con.query(sql, data, callback);
  },

  createDataUser: function (data, callback) {
    sql = `INSERT INTO user SET ?`;
    con.query(sql, data, callback);
  },

  getAllUser: function (callback) {
    sql = `SELECT * from com_user`;
    con.query(sql, callback);
  },

  getByUsername: function (params, callback) {
    sql = `SELECT a.*, b.role_id FROM com_user a INNER JOIN com_role b ON b.role_id = a.role_id WHERE a.username = ? LIMIT 1`;
    con.query(sql, params, callback);
  },

  getByEmail: function (params, callback) {
    sql = `SELECT a.* FROM com_user a WHERE a.email = ? LIMIT 1`;
    con.query(sql, params, callback);
  },

  getExistEmail: function (params, callback) {
    sql = `SELECT a.* FROM com_user a WHERE a.email = ? LIMIT 1`;
    con.query(sql, params, callback);
  },

  getExistHp: function (params, callback) {
    sql = `SELECT a.* FROM com_user a WHERE a.no_hp = ? LIMIT 1`;
    con.query(sql, params, callback);
  },

  getUserByRole: function (params, callback) {
    sql = `SELECT a.* FROM com_user a WHERE a.role_id = ? `;
    con.query(sql, params, callback);
  },

  getUserByID: function (params, callback) {
    sql = `SELECT a.user_id, a.nama, a.email, a.password, a.user_st, DATE_FORMAT(a.tanggal_lahir, "%Y-%m-%d") as tgl_lahir_format FROM com_user a WHERE a.user_id = ?`;
    con.query(sql, params, callback);
  },

  updatePassUser: function (params, callback) {
    sql = `UPDATE com_user SET password = ? WHERE email = ? `;
    con.query(sql, params, callback);
  },

  updateAktifasi: function (params, callback) {
    sql = `UPDATE com_user SET user_st = 'aktif', aktifasi_number = '' WHERE aktifasi_number = ?`;
    con.query(sql, params, callback);
  },

  deleteUser: function (params, callback) {
    sql = `DELETE FROM com_user WHERE user_id = ?`;
    con.query(sql, params, callback);
  },

  UpdateRegister: function (data, callback) {
    sql = `UPDATE com_user SET 
      password = ?,
      token = ?,
      token_key = ?,
      aktifasi_number = ?
      WHERE user_id = ?`;
    con.query(sql, data, callback);
  },

  updateComUserWithPass: function (data, callback) {
    sql = `UPDATE com_user SET 
      nama = ?,
      email = ?,
      tempat_lahir = ?,
      alamat = ?,
      tanggal_lahir = ?,
      password = ?,
      user_st = ?
      WHERE user_id = ?`;
    con.query(sql, data, callback);
  },

  updateComUser: function (data, callback) {
    var sql = `UPDATE com_user SET 
      nama = ?,
      email = ?,
      tempat_lahir = ?,
      alamat = ?,
      tanggal_lahir = ?,
      user_st = ?
      WHERE user_id = ?`;
    con.query(sql, data, callback);
  },
};
