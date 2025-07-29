To set up a local smart home server, you must first download an Apache server
using XAMPP (for Windows) or MAMP Pro (for macOS). To get started, visit the
official XAMPP website at the following link:
https://www.apachefriends.org/ru/index.html.
Download the installation file and run it. When the User Account Control (UAC)
window appears, click "Yes". On the first screen of the installer, click "Next". On the
component selection screen, make sure the following components are selected:
− Apache;
− MySQL;
− PHP;
− phpMyAdmin.

Click "Next" (Fig. 3.1). Select the directory for installation (by default it is
C:xampp). Then click "Next" to continue the installation.

And then "Next" again to start the installation. Wait for the installation
to complete and then click "Finish" After the installation is complete, the XAMPP Control Panel will open. In the
Control Panel, find the "Apache" line and click the "Start" button

If the operation is successful, you will see the message "Apache is running".

<img width="772" height="431" alt="{DFC718CA-A13D-45B7-92EE-74DD08BC3C05}" src="https://github.com/user-attachments/assets/9e1e2163-3010-4b21-ae22-34835a7d8daa" />

After starting the server, install the Smart Home Control Panel in the main
directory (C:\xampp\htdocs). First delete all the files in this folder, then move the
necessary files there. If the installation was successful, when you go to
http://localhost/Test.php (Fig. 3.5) you should see our Control Panel

<img width="730" height="420" alt="{9B55E92E-1CB2-4DCD-83D7-A9EFFEFA480D}" src="https://github.com/user-attachments/assets/6c49ab4e-6f37-49c0-867b-6285d73fab9a" />

Codes, screenshots and comments. The project is quite simple. We program the
Arduino so that it sends data to the server via the ESP module using POST requests.
Below is an example of the code we use for the temperature sensor
