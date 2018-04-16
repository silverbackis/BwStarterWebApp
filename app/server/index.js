import express from 'express'
import { Nuxt, Builder } from 'nuxt'
import session from 'express-session'
import cookieParser from 'cookie-parser'
import helmet from 'helmet'
import api from './api'
import MysqlSession from 'express-mysql-session'
import config from '../nuxt.config.js'
config.dev = process.env.NODE_ENV !== 'production'

const MySQLStore = MysqlSession(session)
const sessionStore = new MySQLStore({
  host: 'mysql',
  port: 3306,
  user: process.env.MYSQL_USER,
  password: process.env.MYSQL_PASSWORD,
  database: process.env.MYSQL_DATABASE
})
let sessOps = {
  secret: process.env.COOKIE_SECRET,
  name: 'JS_SESSION',
  resave: false,
  saveUninitialized: false,
  proxy: true,
  cookie: {
    secure: !config.dev,
    httpOnly: true,
    maxAge: null,
    path: '/'
  },
  store: sessionStore
}

const app = express()
const host = process.env.HOST || '127.0.0.1'
const port = process.env.PORT || 3000

app.set('port', port)
app.disable('x-powered-by')
app.set('trust proxy', !!config.dev)
app.use(session(sessOps))
app.use(helmet())
app.use(cookieParser())
app.use(api)

// Init Nuxt.js
const nuxt = new Nuxt(config)

// Build only in dev mode
if (config.dev) {
  const builder = new Builder(nuxt)
  builder.build()
}

// Give nuxt middleware to express
app.use(nuxt.render)

// Listen the server
app.listen(port, host)
console.log('Server listening on ' + host + ':' + port) // eslint-disable-line no-console
