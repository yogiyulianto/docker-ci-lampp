var createError = require('http-errors');
var express = require('express');
var engine = require('ejs-blocks');
var app = express();
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var session = require('express-session');
var global = require('./config/global_var');

// view engine setup
app.set('views', path.join(__dirname, 'modules'));
app.engine('ejs', engine);
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({extended: false}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));
app.use('/', express.static('public'));
app.use('/admin', express.static('public'));

app.set('trust proxy', 1); // trust first proxy

app.use(
  session({
    secret: 'rahmadz_yca',
    resave: true,
    saveUninitialized: true,
  })
);

// init file router
const sistemRouter = require('./routes/sistem/index');
const adminRouter = require('./routes/admin/index');
const apiRouter = require('./routes/api/index');

// init router
app.use('/', adminRouter);
// Dashboard Router
app.use(sistemRouter);
app.use(apiRouter);

// catch 404 and forward to error handler
app.use(function (req, res, next) {
  next(createError(404));
});

// error handler
app.use(function (err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  ('');
  res.render('z_sistem/views/error');
});

module.exports = app;
