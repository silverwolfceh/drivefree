# Goodle Drive Manager
A google drive manager for service account

# To deploy on Local
1. Clone or download this repo
2. Prepare php webserver (7.x is preferred)
3. Open readme folder to get the credentials and paste all to v1.json

# To deploy to Heroku
1. Create Heroku app and link with this repo 
2. Set some config vars:
- JSON_PREFIX: Any name for file (eg: account_)
- NUM_ACC: number of account that you have (number of service key)
- ACC_1: value is service key 
- ACC_2: value is service key 
- ...
3. Deploy and test


# Available demo
http://drive.viethacker.xyz/

# Todo:
- Delete file still failed to redirect to view because of session header already sent error

# Credits:
- https://www.facebook.com/nguyen.haianh.91 (in J2Team, original source)
- tongvuu@gmail.com (fix error, expand to Heroku)
