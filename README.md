<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

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


## Based on Laravel 8

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling.


## License

The app based on Laravel framework whiсh is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
Same license works for current project.
