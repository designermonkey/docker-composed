FROM node:15

WORKDIR /app
COPY package*.json ./
RUN yarn install
COPY . .
RUN yarn run build

CMD [ "node", "server.js" ]
