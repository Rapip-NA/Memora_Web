name: Deploy Laravel Project on push to cpanel
on:
  push:
    branches:
      - develop
jobs:
  web-deploy:
    name: Deploy
    runs-on: ubuntu-latest
    steps:
      - name: Get the latest code
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'

      - name: Install Composer Dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist --optimize-autoloader

      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '22'

      - name: Install NPM Dependencies & Build
        run: |
          npm install
          npm run build

      - name: 📂 Sync files
        uses: SamKirkland/FTP-Deploy-Action@v4.3.4
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          server-dir: /
          exclude: |
            **/.git*
            **/.git*/**
            **/node_modules/**
            **/tests/**
            .env.example
            .editorconfig
            .gitignore
            .gitattributes
            README.md
