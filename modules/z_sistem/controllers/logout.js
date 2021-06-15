'use strict';

exports.process = function(req, res) {
    req.session.destroy();
    res.redirect('/login')
};


