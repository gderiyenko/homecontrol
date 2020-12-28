## Home controller app
Provides web interface for smart home commands usage.

Users may add smart-devices like Raspberry Pi or any other Unix-based computer as 'Objects' in the application. For item creating user have to set connection settings such as IP-address, username, password and port for future ssh connections.

Users also can CRUD of custom commands in `http://localhost/home/commands`. To run existing commands on related computer authed user can use `Runner` section.

Will be implemented user's email invites and sharing of smart-objects control soon.

## Install
Clone current repository. Then run next `make` command to init Docker containers, setup Laravel .env also composer and npm packages will be installed so on. 

```
make init
```

To see and customize parts of project's deploy check ./Makefile and ./docker directory.
After init command running finished, you are welcome to `http://localhost/`.


```
Login
email: someaddress@gmail.com
password: password
```


Use this creds for inital user. But you may auth with any preinstalled (by Laravel seed) user with `password` as password.

To check the database content you may use any MySQL-provided Database management system. Watch `.env` file to input connection settings rightly.


## License

The app based on Laravel framework whiсh is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
Same license works for current project.
