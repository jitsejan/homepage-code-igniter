<body data-spy="scroll" data-target=".scrollspy">
  <div class="container">
    <div class="row">

      <div id="subnavigation" class="col-md-3 scrollspy hidden-xs hidden-sm">
        <ul id="subnav" class="subnav toc" data-spy="affix">
          <!-- <li><a href="#setupaws">Set up AWS</a></li> -->
        </ul>
      </div>
     <div class="col-md-9 col-sm-12 col-xs-12 tutorial-container">
         <div class="row page-header">
        <h1><?php echo $title; ?></h1>
    </div>
        I am planning to add tutorials in the (near) future. For now this page will contain my howto on creating the Ruby on Rails app that I am developing.
       <article>
       <h1 id="setupaws">Set up the AWS EC instance</h1>
       <ol>
          <li>Go to the EC <a href="https://eu-central-1.console.aws.amazon.com/ec2/v2/home?region=eu-central-1#Instances:sort=instanceId">page</a></li>
           <li>Launch Instance</li>
           <li>Select <b>Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - ami-87564feb</b></li>
           <li>Select <b>t2.micro (Free tier eligible)</b></li>
           <li>Select <b>Next: Configure Instance Details</b></li>
           <li>Select <b>Next: Add Storage</b></li>
           <li>Select <b>Next: Tag Instance</b></li>
           <li>Give a <i>Name</i> to the Instance</li>
           <li>Select <b>Next: Configure Security Group</b></li>
           <li>Create a new security group</li>
           <li>Add a <i>Security group name</i></li>
           <li>Add a <i>Description</i></li>
           <li>Add rule by clicking <b>Add Rule</b></li>
           <li>First rule should be <b>Custom TCP Rule, TCP Protocol, Port 80 for source Anywhere</b></li>
           <li>Click on <b>Launch</b></li>
           <li>Select <b>Review and launch</b></li>
           <li>In the pop-up, select <b>Create a new key pair</b></li>
           <li>Fill in a <i>Key pair name</i></li>
           <li>Download the <i>Key Pair</i> and save in a <u>secure</u> location</li>
           <li>Launch the instance</li>
           <li>Go to <a href="https://eu-central-1.console.aws.amazon.com/ec2/v2/home?region=eu-central-1#Instances:sort=instanceId">instance page</a> and wait until the machine is ready</li>
       </ol>

       <h1 id="connectaws">Connect to the EC instance</h1>
       Once the machine is ready, connect to the machine using SSH.
       <ol>
         <li>On your computer, change the permissions of the key pair you just downloaded</li>
          <p class="command-mb">$ chmod 400 keypairfile.pem</p>
          <li>Connect to the machine via ssh. Click on the Connect button in the instance overview for connection information</li>
          <p class="command-mb">$ ssh -i “keypairfile.pem” ec2-xx-xx-x-xx.eu-central-1.compute.amazonaws.com</p>
      </ol>


       <h1 id="rubyinstall">Install Ruby on Rails</h1>
       Following the <a href="https://gorails.com/deploy/ubuntu/14.04">guide</a> with RVM.
       <h2 id="rubyprep">Update and prepare system</h2>
       <ol>
         <li>Update the system first.<p class="command-lnx">$ sudo apt-get update</p></p></li>
         <li>Install all dependencies we need<p class="command-lnx">$ sudo apt-get install git-core curl zlib1g-dev build-essential libssl-dev libreadline-dev libyaml-dev libsqlite3-dev sqlite3 libxml2-dev libxslt1-dev
           libcurl4-openssl-dev python-software-properties libffi-dev libgmp-dev libgdbm-dev libncurses5-dev automake libtool bison</p></li>
       </ol>
       <h2 id="rubyrvm">Install the Ruby Version Manager (RVM)</h2>
       <ol>
         <li>Add the key for retrieving the rvm installer.<p class="command-lnx">$ gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3</p></li>
         <li>Download and install rvm.<p class="command-lnx">$ curl -L https://get.rvm.io | bash -s stable</p></li>
         <li>Make RVM available in the prompt.<p class="command-lnx">$ source ~/.rvm/scripts/rvm</p></li>
       </ol>
       <h2 id="rubyv">Install Ruby</h2>
       <ol>
         <li>Use RVM to install rails version 2.2.4.<p class="command-lnx">$ rvm install 2.2.4</p></li>
         <li>Set 2.2.4 as system default.<p class="command-lnx">$ rvm use 2.2.4 --default</p></li>
         <li>Check if the correct version is displayed.<p class="command-lnx">$ ruby -v</p></li>
         <li>Using gem, install bundler.<p class="command-lnx">$ gem install bundler</p></li>
         <li>After installing bundler, install the rails gem.<p class="command-lnx">$ gem install rails</p></li>
       </ol>
       <h2 id="rubynodejs">Install NodeJS</h2>
       <ol>
         <li>Add the repository for the installation of NodeJS.<p class="command-lnx">$ curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -</p></li>
         <li>Use apt-get to install NodeJS.<p class="command-lnx">$ sudo apt-get install -y nodejs</p></li>
       </ol>

       <h1 id="nginx">Install webserver Nginx</h1>
       <h2 id="nginxinstall">Installation</h2>
       Install the Nginx webserver with the Passenger plugin.
       <ol>
         <li>Retrieve the key for the Nginx installation.<p class="command-lnx">$ sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 561F9B9CAC40B2F7</p></li>
         <li>Install the dependencies.<p class="command-lnx">$ sudo apt-get install -y apt-transport-https ca-certificates</p></li>
         <li>Add the Passenger repository.<p class="command-lnx">$ sudo sh -c 'echo deb https://oss-binaries.phusionpassenger.com/apt/passenger trusty main > /etc/apt/sources.list.d/passenger.list'</p></li>
         <li>Update the system.<p class="command-lnx">$ sudo apt-get update</p></li>
         <li>Install the webserver including Passenger<p class="command-lnx">$ sudo apt-get install -y nginx-extras passenger</p></li>
         <li>Install the module.<p class="command-lnx">$ rvmsudo passenger-install-nginx-module</p></li>
         <li>Validate the install.<p class="command-lnx">$ rvmsudo passenger-config validate-install</p></li>
         <li>Start the webserver.<p class="command-lnx">$ sudo service nginx start</p></li>
       </ol>
       <h2 id="valnginx">Validation</h2>
       To validate the server is installed, go back to the <a href="https://eu-central-1.console.aws.amazon.com/ec2/v2/home?region=eu-central-1#Instances:sort=instanceId">AWS console</a> and click on the running Instance.
       Check the <i>Public DNS</i> and copy the link to your browser. You should now see the <i>Welcome to nginx on Ubuntu!</i> welcome message.

       <h1 id="passenger">Configure Passenger</h1>
       <ol>
         <li>Verify the <code>passenger_ruby</code>.<p class="command-lnx">$ passenger-config —ruby-comand</li>
         <li>Copy the Nginx <code>passenger_ruby</code> path to the clipboard. In my case: <code>passenger_ruby /home/ubuntu/.rvm/gems/ruby-2.2.4/wrappers/ruby;</code> (Mind the semi-colon)</li>
         <li>Add the path to the config.
           <ol>
            <li><p class="command-lnx">$ sudo nano /etc/nginx/nginx.conf</li>
            <li>Uncomment the <code>passenger_root</code>.</li>
            <li>Paste the line from Step 2 and remove the other <code>#passenger_ruby</code>.</li>
            <li>Save the file and quit nano</li>
          </ol>
        </li>
        <li>Restart the webserver.<p class="command-lnx">$ sudo service nginx restart</li>
        <li>Verify that the website is still in the air and refresh the webpage.</li>
      </ol>

      <h1 id="mysql">Install MySQL</h1>
      <ol>
        <li>Install the dependencies.<p class="command-lnx">$ sudo apt-get install mysql-server mysql-client libmysqlclient-dev</p></li>
        <li>Fill in a root password.</li>
      </ol>

      <h1 id="app">Create application</h1>
      Create a new application using Ruby on Rails
      <ol>
        <li><p class="command-lnx">$ rails new mynewapp</p></li>
        <li><p class="command-lnx">$ cd mynewapp</p></li>
        <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ bundle install</p></li>
        <li><p class="command-lnx">$ sudo nano /etc/nginx/sites-enabled/default</p>
        Change it into the following (assuming you are the <i>ubuntu</i> user and the app is created in <i>/home/ubuntu/mynewapp/</i>):
        <pre class="prettyprint">server {
  listen 80 default_server;
  listen [::]:80 default_server ipv6only=on;
  server_name mynewapp.com;
  passenger_enabled on;
  rails_env development;
  root /home/ubuntu/mynewapp/public;
  # redirect server error pages to the static page /50x.html
  error_page 500 502 503 504 /50x.html;
  location = /50x.html {
      root html;
    }
  }</pre></li>
          <li>Restart the webserver.<p class="command-lnx">$ sudo service nginx restart</p></li>
        </ol>




       <h1 id="addgit">Add git respository</h1>
       <ol>
       <li>Change directory to your app.<p class="command-lnx">$ cd ~/mynewapp</p></li>
       <li>Initialize the git repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git init</p></li>
       <li>Add a remote site to save your repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git remote add origin https://jitsejan@bitbucket.org/jitsejan/mynewapp.git</p></li>
       <li>Add your name to a new file <code>contributors.txt</code>.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ echo "Jitse-Jan" >> contributors.txt</p></li>
       <li>Add this file to the repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git add contributors.txt</p></li>
       <li>Commit the change with a description.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git commit -m 'Initial commit with contributors'</p></li>
       <li>Push the changes to the server.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git push -u origin master</p></li>
       <li>Check if the changes are visible in your respository.</li>
       <li>Add the whole folder to your git repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git add .</p></li>
       <li>Check the status. You should see a long list with files that needs to be committed.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git status</p></li>
       <li>Commit the changes.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git commit -m ‘Initial commit of the app’</p></li>
       <li>Push the changes again to the server.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git push -u origin master</p></li>
       <li>There shouldn't be any changes left now.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git status</p></li>
     </ol>


       <h1 id="firstpage">The first page</h1>
       <ol>
       <li>Create a controller for the welcome page.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ bin/rails generate controller welcome index
       <li>Add a welcome text in the view.
         <ol>
           <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano app/views/welcome/index.html.erb</p></li>
            <li>Add <i>Welcome to my app</i></li>
            <li>Save and close the file</li>
          </ol>
        </li>
       <li>Create a route to the new page.
         <ol>
           <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano config/routes.rb</p></li>
           <li>Uncomment the <code>#root ‘welcome#index’</code></li>
           <li>Save and close</li>
         </ol>
       </li>
       <li>First page is ready, check the website!</li>
       <li>Commit the changes
         <ol>
           <li>Check the status of the repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git status</p></li>
           <li>Add all (new) files to the repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git add .</p></li>
           <li>Commit the changes.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git commit -m “Creation of welcome page”</p></li>
           <li>Push the changes to the online repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git push origin master</p></li>
           <li>Check again the status of the git repository.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ git status</p></li>
         </ol>
       </li>

       <h1 id="firstresource">The first resource</h1>
       <ol>
         <li>Add the resource <i>items</i> to the application.
           <ol>
             <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano config/routes.rb</li>
              <li>Add <code>resources :items</code></li>
              <li>Save and exit</li>
             </ol>
           </li>
           <li>Create a route for the items.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ bin/rake routes</li>
           <li>Create a <b>controller</b> for <i>items</i>.<p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ bin/rails generate controller items</li>
          <li>Add a basic function to the controller
            <ol>
              <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano app/controllers/items_controller.rb</p></li>
              <li>Add the following:
                <pre class="prettyprint">def new
end</pre>
              <li>Save and exit</li>
            </ol>
          </li>
          <li>Create a <b>view</b> for items.
            <ol>
              <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano app/views/items/new.html.erb</p></li>
              <li>Add <xmp><h1>New item</h1></xmp></li>
              <li>Save and exit</li>
            </ol>
          </li>
          <li>Check the website (<a href="http://ec2-xx-xx-xx.eu-central-1.compute.amazonaws.com/items/new">http://ec2-xx-xx-xx.eu-central-1.compute.amazonaws.com/items/new</a>)</li>
          <li>Add a form to the outfit view
            <ol>
              <li><p class="command-lnx"><span class="cmd-dir">~/mynewapp/</span> $ nano app/views/items/new.html.erb</p></li>
              <li>Append the following:
                <xmp class="prettyprint"><%= form_for :article do |f| %>
<p>
  <%= f.label :title %><br>
  <%= f.text_field :title %>
</p>

<p>
  <%= f.label :text %><br>
  <%= f.text_area :text %>
</p>

<p>
  <%= f.submit %>
</p>
<% end %></xmp>
            </li>
            <li>Save and exit</li>
          </ol>
        </li>
        </ol>
        <h1 id="fileaccess">File access (Mac)</h1>
        Do the following on OS X to make it more convenient modifying and browsing the files:
        <ol>
          <li>Install <a href="https://osxfuse.github.io">Fuse for OS X</a></li>
          <li>Install <a href="https://github.com/osxfuse/sshfs/releases/download/osxfuse-sshfs-2.5.0/sshfs-2.5.0.pkg">SSHFS</a> (2.5.0 at the time of writing)</li>
          <li><p class="command-mb"><span class="cmd-dir">~/</span> $ mkdir ~/AWSdrive</p></li>
          <li><p class="command-mb"><span class="cmd-dir">~/</span> $ sshfs ubuntu@ec2-xx-xx-xx-xx.eu-central-1.compute.amazonaws.com:/home/ubuntu/ ~/AWSdrive/ -oauto_cache,reconnect,defer_permissions,noappledouble,negative_vncache</p></li>
          <li>Fill in your password and the drive will be mounted</li>
        </ol>
        To be continued...
     </article>
     </div>
     </div><!-- /row !-->
   </div><!-- /container !-->
    <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
    </script>


  </body>
