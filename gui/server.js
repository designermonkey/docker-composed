const express = require('express')
const session = require('express-session')
const cors = require('cors')
const path = require('path')

require('dotenv').config()

const app = express()
const pub = 'dist'
const port = process.env.port || 3000

app.use(cors({ origin: true, credentials: true }))
app.use(express.json())
app.use(express.static(pub))
app.use(session({
  secret: process.env.secret ?? '1234567890',
  resave: false,
  saveUninitialized: false,
  cookie: {
    secure: 'auto',
    httpOnly: true,
    maxAge: 3600000
  }
}))

app.get('/', (request, response) => {
  response.sendFile(path.join(__dirname, pub, 'index.html'))
})

app.use('/user', require('./server/user'))
app.use('/login', require('./server/login'))
app.use('/logout', require('./server/logout'))
app.use('/oauth-callback', require('./server/oauth-callback'))
app.use('/set-user-data', require('./server/set-user-data'))

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`)
})
