'use strict';
const bcrypt = require('bcrypt');
const fs = require('fs');
const multer = require('multer');
var path = require('path')
const jwt = require('jsonwebtoken');


// models
const _MUser = require('./../models/user')

// library
const global = require('./../../../config/global_var');
const helper_ext = require('./../../../config/helper_ext');
const basemailer = require('./../../../config/mail');

// file configuration
const storage = multer.diskStorage({
    destination: path.join(__dirname + './../../../public/doc/merchant/images'),
    filename: function (req, file, cb) {
        var ext = path.extname(file.originalname);
        if (ext !== '.png' && ext !== '.jpg' && ext !== '.jpeg') {
            return cb(new Error('Hanya file jenis gambar yang diperbolehkan !'))
        }
        cb(null, file.fieldname + '-' + Date.now() + ext);
    }
});

//init upload
const upload = multer({
    storage: storage
});

module.exports = {
    index: function (req, res) {
        // status login true
        req.session.loggedin = true;

        //notif
        var st_process = req.cookies["st_process"]; res.clearCookie("st_process"); var notif = req.cookies["notif"]; res.clearCookie("notif");

        //cek login
        if (req.session.loggedin) {
            var data_login = { nama: req.session.nama, role_id: req.session.role_id, email: req.session.email }
            res.render(path.join(__dirname, '../views/user/index'), {
                title: 'User',
                st: st_process,
                notif: notif,
                dataLogin: data_login,
            });
        } else {
            //login gagal
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/login');
        }
    },
    add_admin: function (req, res) {
        req.session.loggedin = true;

        //notif
        var st_process = req.cookies["st_process"]; res.clearCookie("st_process"); var notif = req.cookies["notif"]; res.clearCookie("notif");
        var data_login = { nama: req.session.nama, role_id: req.session.role_id, email: req.session.email }


        //cek login
        if (req.session.loggedin) {
            res.render(path.join(__dirname, '../views/user/add_admin'), {
                title: 'User Admin',
                subtitle: 'Tambah Data User Admin',
                st: st_process,
                notif: notif,
                dataLogin: data_login,
            });
        } else {
            //Sukses
            res.cookie("st_process", "Gagal");
            res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin.");
            res.redirect('/');
        }
    },
    add_admin_process: function (req, res) {
        req.session.loggedin = true;
        //cek login
        if (req.session.loggedin) {

            // logic
            var nama = req.body.nama_lengkap;
            var tempat_lahir = req.body.tempat_lahir;
            var alamat = req.body.alamat;
            var email = req.body.email;
            var tanggal_lahir = req.body.tanggal_lahir;
            var password = req.body.user_pass;
            var user_st = req.body.user_st;

            // 
            var number;
            var user_id;
            var dateObj = new Date();
            var month = helper_ext.getMonth2d(dateObj); //months from 01-12
            var day = helper_ext.getDate2d(dateObj);
            var year = dateObj.getUTCFullYear();
            //buat prefix
            var prefix = year + "" + month + "" + day;


            if (tempat_lahir && password && nama && email && alamat && tanggal_lahir && user_st) {

                // get last_id
                _MUser.getLastId(function (err, rows) {
                    // jika error
                    if (err) {
                        console.log(err)
                    } else if (!rows[0]) {
                        user_id = prefix + '1';
                    } else if (!rows[0].first_number) {
                        user_id = prefix + '1';
                    } else if (rows[0].first_number) {
                        number = parseInt(rows[0]['first_number']) + 1;
                        user_id = prefix + number;
                    }

                    // cek email terdaftar
                    _MUser.getExistEmail(email, function (err, rows) {
                        if (err) throw err

                        if (rows[0]) {
                            res.cookie("st_process", "Gagal"); res.cookie("notif", "Email telah terdaftar, gunakan email lain !"); res.redirect('/admin/add_admin');
                        } else {
                            const saltRounds = 10;
                            // hash pass
                            bcrypt.hash(password, saltRounds, function (err, hash) {
                                    //insert ke com_user
                                    var params_com_user = {
                                        user_id: user_id,
                                        role_id: 1,
                                        nama: nama,
                                        email: email,
                                        password: hash,
                                        tempat_lahir: tempat_lahir,
                                        tanggal_lahir: tanggal_lahir,
                                        alamat: alamat,
                                        user_st: user_st,

                                    };
                                    //   insert com_user
                                    _MUser.createUser(params_com_user, function (err) {
                                        if (err) throw err
                                        // konfig email
                                        var mailOptions = {
                                            from: basemailer.sender,
                                            to: email,
                                            subject: 'Registrasi akun Aplikasi PPOB PT. Hexa Indonesia Teknologi',
                                            html: 'Selamat anda berhasil mendaftar <b> PPOB PT. Hexa Indonesia Teknologi </b> sebagai <b>Administrator</b>. <p> Gunakan data berikut untuk login kedalam website : <br><b>Email : </b>' + email + '<br><b>Password: </b>' + password
                                        };

                                        // sendmail
                                        basemailer.transporter.sendMail(mailOptions, function (error, info) {
                                            if (error) {
                                                console.log(error);
                                                //Gagal
                                                res.cookie("st_process", "Gagal"); res.cookie("notif", "User berhasil ditambahkan, tapi email tidak dapat dikirim."); res.redirect('/admin/add_admin');
                                            } else {
                                                console.log('Email sent: ' + info.response);
                                                //Sukses
                                                res.cookie("st_process", "Sukses"); res.cookie("notif", "User berhasil ditambahkan, data login dikirimkan ke email tujuan."); res.redirect('/admin/add_admin');
                                            }
                                        })
                                    })
                            });
                        }
                    });
                })
            } else {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak lengkap !"); res.redirect('/admin/add_admin');
            }

        } else {
            //Gagal
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }

    },
    add_member: function (req, res) {
        req.session.loggedin = true;

        //notif
        var st_process = req.cookies["st_process"]; res.clearCookie("st_process"); var notif = req.cookies["notif"]; res.clearCookie("notif");

        var data_login = { nama: req.session.nama, role_id: req.session.role_id, email: req.session.email }
        //cek login
        if (req.session.loggedin) {
            res.render(path.join(__dirname, '../views/user/add_member'), {
                title: 'User Member',
                subtitle: 'Tambah Data User Member',
                st: st_process,
                notif: notif,
                dataLogin: data_login,
            });
        } else {
            //Sukses
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }
    },
    add_member_process: function (req, res) {
        req.session.loggedin = true;
        //cek login
        if (req.session.loggedin) {

            // logic
            var nama = req.body.nama_lengkap;
            var tempat_lahir = req.body.tempat_lahir;
            var alamat = req.body.alamat;
            var email = req.body.email;
            var tanggal_lahir = req.body.tanggal_lahir;
            var password = req.body.user_pass;
            var user_st = req.body.user_st;

            // 
            var number;
            var user_id;
            var dateObj = new Date();
            var month = helper_ext.getMonth2d(dateObj); //months from 01-12
            var day = helper_ext.getDate2d(dateObj);
            var year = dateObj.getUTCFullYear();
            //buat prefix
            var prefix = year + "" + month + "" + day;


            if (tempat_lahir && password && nama && email && alamat && tanggal_lahir && user_st) {

                // get last_id
                _MUser.getLastId(function (err, rows) {
                    // jika error
                    if (err) {
                        console.log(err)
                    } else if (!rows[0]) {
                        user_id = prefix + '1';
                    } else if (!rows[0].first_number) {
                        user_id = prefix + '1';
                    } else if (rows[0].first_number) {
                        number = parseInt(rows[0]['first_number']) + 1;
                        user_id = prefix + number;
                    }

                    // cek email terdaftar
                    _MUser.getExistEmail(email, function (err, rows) {
                        if (err) throw err

                        if (rows[0]) {
                            res.cookie("st_process", "Gagal"); res.cookie("notif", "Email telah terdaftar, gunakan email lain !"); res.redirect('/admin/add_admin');
                        } else {
                            const saltRounds = 10;
                            // hash pass
                            bcrypt.hash(password, saltRounds, function (err, hash) {
                                    if (err) throw err

                                                            // create token
                                    var token_key = helper_ext.generatechar(6);
                                    var token = jwt.sign({
                                        id: user_id
                                    }, token_key, {
                                        expiresIn: 99999999999999999999999999999999999999999 //24h expired
                                    });

                                    //insert ke com_user
                                    var params_com_user = {
                                        user_id: user_id,
                                        role_id: 2,
                                        nama: nama,
                                        email: email,
                                        password: hash,
                                        token: token,
                                        token_key: token_key,
                                        tempat_lahir: tempat_lahir,
                                        tanggal_lahir: tanggal_lahir,
                                        alamat: alamat,
                                        user_st: user_st,
                                    };
                                    //   insert com_user
                                    _MUser.createUser(params_com_user, function (err) {
                                        if (err) throw err
                                        // konfig email
                                        var mailOptions = {
                                            from: basemailer.sender,
                                            to: email,
                                            subject: 'Registrasi akun Aplikasi PPOB PT. Hexa Indonesia Teknologi',
                                            html: 'Selamat anda berhasil mendaftar <b> PPOB PT. Hexa Indonesia Teknologi </b> sebagai <b>Administrator</b>. <p> Gunakan data berikut untuk login kedalam website : <br><b>Email : </b>' + email + '<br><b>Password: </b>' + password
                                        };

                                        // sendmail
                                        basemailer.transporter.sendMail(mailOptions, function (error, info) {
                                            if (error) {
                                                console.log(error);
                                                //Gagal
                                                res.cookie("st_process", "Gagal"); res.cookie("notif", "User berhasil ditambahkan, tapi email tidak dapat dikirim."); res.redirect('/admin/add_admin');
                                            } else {
                                                console.log('Email sent: ' + info.response);
                                                //Sukses
                                                res.cookie("st_process", "Sukses"); res.cookie("notif", "User berhasil ditambahkan, data login dikirimkan ke email tujuan."); res.redirect('/admin/add_admin');
                                            }
                                        })
                                    })
                            });
                        }
                    });
                })
            } else {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak lengkap !"); res.redirect('/admin/add_admin');
            }

        } else {
            //Gagal
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }

    },
    edit_user: function (req, res) {
        req.session.loggedin = true;

        //notif
        var st_process = req.cookies["st_process"]; res.clearCookie("st_process"); var notif = req.cookies["notif"]; res.clearCookie("notif");

        var data_login = { nama: req.session.nama, role_id: req.session.role_id, email: req.session.email }

        //cek login
        if (req.session.loggedin) {

            var user_id = req.query.user_id;

            // get data user
            _MUser.getUserByID(user_id, function (err, rows) {
                if (err) throw err

                if (!rows[0]) {
                    //gagal
                    res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak ditemukan."); res.redirect('/admin/user');
                } else {

                    res.render(path.join(__dirname, '../views/user/edit_user'), {
                        title: 'User',
                        subtitle: 'Edit Data User',
                        st: st_process,
                        notif: notif,
                        dataLogin: data_login,
                        result: rows[0],
                    });
                }
            })

        } else {
            //Gagal
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }
    },
    edit_user_process: function (req, res) {
        req.session.loggedin = true;
        //cek login
        if (req.session.loggedin) {

            // init
            var nama = req.body.nama_lengkap;
            var tempat_lahir = req.body.tempat_lahir;
            var alamat = req.body.alamat;
            var email = req.body.email;
            var tanggal_lahir = req.body.tanggal_lahir;
            var password = req.body.user_pass;
            var user_st = req.body.user_st;
            var user_id = req.body.user_id;

            // validasi
            if (tempat_lahir && nama && email && alamat && tanggal_lahir && user_st) {

                // dengan password
                if (password) {
                    const saltRounds = 10;
                    // hash pass
                    bcrypt.hash(password, saltRounds, function (err, hash) {
                        //update ke com_user
                        var params_com_user = [nama, email, tempat_lahir, alamat, tanggal_lahir, hash, user_st, user_id];
                        //   update com_user
                        _MUser.updateComUserWithPass(params_com_user, function (err) {
                            if (err) throw err

                            res.cookie("st_process", "Sukses"); res.cookie("notif", "Data berhasil diubah"); res.redirect('/admin/edit_user?user_id=' + user_id);
                        })
                    });
                } else {
                    // tanpa password
                    //update ke com_user
                    var params_com_user = [nama, email, tempat_lahir, alamat, tanggal_lahir, user_st, user_id];
                    //   update com_user
                    _MUser.updateComUser(params_com_user, function (err) {
                        if (err) throw err
                        //notif
                        res.cookie("st_process", "Sukses"); res.cookie("notif", "Data berhasil diubah"); res.redirect('/admin/edit_user?user_id=' + user_id);
                    })
                }

            } else {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak lengkap !"); res.redirect('/admin/edit_user?user_id=' + user_id);
            }

        } else {
            //Sukses
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }
    },
    delete_process: function (req, res) {
        req.session.loggedin = true;
        //cek login
        if (req.session.loggedin) {
            var user_id = req.body.user_id;
            if (user_id) {

                // get last_id
                _MUser.deleteUser(user_id, function (err) {
                    // jika error
                    if (err) {
                        console.log(err)
                        //  //Sukses
                        var notif = {
                            status: "gagal",
                            message: "Gagal menghapus data !"
                        };
                        res.json(notif);
                    }
                    //Sukses
                    var notif = {
                        status: "sukses",
                        message: "Data berhasil dihapus."
                    };
                    res.json(notif);

                });
            } else {
                //Gagal
                var notif = {
                    status: "Gagal",
                    message: "Data tidak lengkap !"
                };
                res.json(notif);
            }

        } else {
            //Gagal
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/');
        }

    },
    get_list_user: function (req, res) {
        req.session.loggedin = true;
        //cek login
        if (req.session.loggedin) {
            // logic
            var role_id = req.query.role_id;

            if (role_id) {
                // get last_id
                _MUser.getUserByRole(role_id, function (err, rows) {
                    // jika error
                    if (err) {
                        console.log(err)
                        //  //Sukses
                        var notif = {
                            status: "Gagal",
                            message: "mengambil data !"
                        };
                        res.json(notif);
                        res.end()
                    }

                    //Sukses
                    var notif = {
                        status: "Sukses",
                        message: "Data berhasil diambil."
                    };

                    res.json(rows);
                    res.end()
                    return false;
                });

            } else {
                res.cookie("st_process", "Gagal"); res.cookie("notif", "Data tidak ditemukan !"); res.redirect('/admin/user');
            }

        } else {
            //Sukses
            res.cookie("st_process", "Gagal"); res.cookie("notif", "Anda belum login, silahkan login untuk mengakses website admin."); res.redirect('/login');
        }

    },
}