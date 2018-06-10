FROM ubuntu:xenial
MAINTAINER DarkyAngel <darkyangel@protonmail.com>

RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
    apache2 php7.0 php7.0-mysql libapache2-mod-php7.0 curl

# Enable apache mods.
RUN a2enmod php7.0
RUN a2enmod rewrite

RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.0/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.0/apache2/php.ini
RUN sed -i "s/\;open_basedir .*$/open_basedir = \/var\/www\/site/" /etc/php/7.0/apache2/php.ini
RUN sed -i "s/disable_functions = .*$/disable_functions = pcntl_alarm,pcntl_fork,pcntl_waitpid,pcntl_wait,pcntl_wifexited,pcntl_wifstopped,pcntl_wifsignaled,pcntl_wifcontinued,pcntl_wexitstatus,pcntl_wtermsig,pcntl_wstopsig,pcntl_signal,pcntl_signal_dispatch,pcntl_get_last_error,pcntl_strerror,pcntl_sigprocmask,pcntl_sigwaitinfo,pcntl_sigtimedwait,pcntl_exec,pcntl_getpriority,pcntl_setpriority,system,exec,shell_exec,passthru,phpinfo,show_source,popen,proc_open,fopen_with_path,dbmopen,dbase_open,move_uploaded_file,chdir,rmdir,chmod,rename,filepro,filepro_rowcount,filepro_retrieve,posix_mkfifo/" /etc/php/7.0/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Expose apache.
EXPOSE 80

# Copy this repo into place.
ADD www /var/www/site

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND

# Set permissions accordingly.. can never be sure :^)
RUN rm -rf /var/www/site/tmp && \
    mkdir /var/www/site/tmp && \
    chmod 555 /var/www/site && \
    chmod -R 444 /var/www/site/* && \
    chmod 333 /var/www/site/tmp

# Initialise part2 of the challenge

# Add the flag and get_flag files for part2
ADD flag2 /flag2
ADD get_flag /get_flag

# Add a htaccess to disable execution in tmp/ and hide tmp/ from the webserver
ADD htaccess_tmp /var/www/site/tmp/.htaccess
RUN chmod 555 /var/www/site/tmp/.htaccess

# Create unprivileged user that can only read the flag
RUN useradd -ms /usr/sbin/nologin headmaster

# Set permissions for the second part of the challenge
RUN chmod 400 /flag2 && \
    chown headmaster:headmaster /flag2 && \
    chmod 555 /get_flag && \
    chown headmaster:headmaster /get_flag && \
    chmod +s /get_flag
