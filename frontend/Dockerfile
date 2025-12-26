FROM node:lts-alpine

RUN npm config set registry https://registry.npmmirror.com

WORKDIR /app

COPY package*.json ./

RUN npm install --no-audit --no-fund --prefer-offline

COPY . .

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
