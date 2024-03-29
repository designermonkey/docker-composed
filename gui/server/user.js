const express = require('express')
const router = express.Router()
const axios = require('axios')
const qs = require('querystring')

router.get('/', (req, res) => {
  // token in session -> get user data and send it back to the vue app
  if (req.session.token) {
    axios
      .post(`http://localhost:${process.env.FUSIONAUTH_PORT}/oauth2/introspect`, qs.stringify({
        client_id: process.env.CLIENT_ID,
        token: req.session.token
      }))
      .then((result) => {
        const introspectResponse = result.data
        // valid token -> get more user data and send it back to the Vue app
        if (introspectResponse) {
          // GET request to /registration endpoint
          axios
            .get(`http://localhost:${process.env.FUSIONAUTH_PORT}/api/user/registration/${introspectResponse.sub}/${process.env.APPLICATION_ID}`, {
              headers: {
                Authorization: process.env.API_KEY
              }
            })
            .then((response) => {
              res.send({
                authState: 'Authorized',
                introspectResponse: introspectResponse,
                body: response.data.registration
              })
            })
            .catch((err) => {
              res.send({
                authState: 'notAuthorized'
              })
              console.log(err)
            })
        } else {
          // expired token -> send nothing
          req.session.destroy()
          res.send({
            authState: 'notAuthenticated'
          })
        }
      })
      .catch((err) => {
        console.log(err)
      })
  } else {
    // no token -> send nothing
    res.send({
      authState: 'notAuthenticated'
    })
  }
})

module.exports = router
