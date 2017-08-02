Find instructions here : <a href="https://openclassrooms.com/projects/developpez-un-back-end-pour-un-client">"Développez un back-end pour un client"</a>

Website is alvaible at this adress : <a href="http://leogrambert.fr/front/projets/louvre">http://leogrambert.fr/front/projets/louvre</a>

<hr>

<h4>How to download and use this project</h4>

<h5>1. Download <a href="https://leogrambert.fr/front/projets/louvre/projet4_CPMDev-master.zip">this</a></h5>

<h5>2. Unzip it where you want</h5>

<h5>3. In your command prompt, go in Symfony/ and launch <code>composer install</code>. Then, go in your new file app/config/parameters.yml and add this line : <code>mailer_encryption: ssl</code></h5>

<h5>4. In your command prompt, run the followings commands :<br>
<code>php bin/console doctrine:database:create</code><br>
<code>php bin/console doctrine:schema:update --force</code><br>
<code>php bin/console assets:install</code><br></h5>

<h5>5. Then launch the server with this command <code>php bin/console server:start</code> and go to this adress : http://127.0.0.1:8000/fr/</h5>

<hr>

If you encounter problems during installation, contact me (leo@grambert.fr)
