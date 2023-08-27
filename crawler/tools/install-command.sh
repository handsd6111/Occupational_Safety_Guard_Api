sudo apt update
sudo apt install python3-pip -y
pip install selenium
pip install pymysql
pip install --upgrade requests
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt -f install -y
sudo cp chromedriver /usr/local/bin/chromedriver
sudo chmod 755 /usr/local/bin/chromedriver
google-chrome --version
chromedriver
