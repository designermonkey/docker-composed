FROM node:15

WORKDIR /app

COPY . .

RUN yarn install
RUN yarn run build

CMD [ "node", "server.js" ]
