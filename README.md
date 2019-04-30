# dns-updater
Updates your DNS records on your DNS provider when it changes.

## About
This project is a PHP utility used to update DNS Records on multiple DNS providers. It is basically used to keep an DNS "A" Record in sync with your public IP automatically, on any provider.

Currently available providers are:

- Cloudflare
- DigitalOcean

## Usage

### Running Locally

This tool does not ensure that your configurations are correct. Configure your DNS settings correctly on your provider first, and use this tool only to keep the record updated.

1. Download the project locally

```sh
git clone https://github.com/rumd3x/dns-updater.git
# or
composer create-project rumd3x/dns-updater
```

Make sure to install the dependencies with `composer install` when using git clone.

2. Copy the `.env.example` file to `.env` and fill in the necessary parameters. 

- `PROVIDER` should be either `digitalocean` or `cloudflare`.
- `KEY` Your API key of the provider. If your provider is cloudflare it should be `email@email.com;your-api-key`.
- `DOMAIN` The domain that your record belongs to, like `mysite.com`.
- `RECORD` The record that will be updated E.g. `'ddns'` for updating the record at `ddns.mysite.com`.

3. Now run the `app/bootstrap.php` file and watch your DNS records get updated.
4. Put the command to call the project on a schedule (Like a cron running it every 5 minutes or so) to make sure it is always up to date.

### Running the docker way

You can also run this project using docker. It will run the project on a schedule (every 5 mins) by default. Just run the following command and you are good to go (refer for the environment variables definitions in the section above).

```sh
docker run --name dns-updater-mysite-ddns \
--env PROVIDER=cloudflare \
--env KEY=email@email.com;my-api-key-here \
--env DOMAIN=mysite.com \
--env RECORD=ddns \
--restart unless-stopped \
edmur/dns-updater
```

To check what's going on inside the container just run:

```sh
docker logs dns-updater-mysite-ddns
```
