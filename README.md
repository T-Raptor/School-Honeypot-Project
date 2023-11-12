# Honeypot and Secure Web Environment Setup



### 1 Honeypots

A honeypot is a security mechanism designed to detect and monitor unauthorized access or attacks on a network or system. In this project, we will implement a honeypot (python script) to detect and analyze potential security threats. The honeypot will run on a custom port and record interaction attempts from potential attackers.

### 1.1  Here's how the code works:

- It imports the socket module, which is used to create a network socket and handle incoming connections.

- It defines the honeypot_port variable, specifying the port number on which the honeypot will listen for incoming connections.

- The start_honeypot function sets up the honeypot server using a  block for proper resource management. It binds the server socket to all available network interfaces on a specified port and starts listening for incoming connections.

- When a connection is established, it logs the IP address of the connecting client 


- The code logs the connection and login attempt details to a file named 'honeypot.log'  and responds to the client with a login failure message.

- The start_honeypot function continues to listen for new connections in an infinite loop.


### 2 Secure Web Environment

In addition to the honeypot, we will create a secure web environment with the following features:

- User authentication with secure login.
- User registration without email verification, captcha, or 2FA.
- User account management, including enabling/disabling users.
- Uploading avatars.
- A secure admin panel for user management.
- Extensive logging with Kibana integration for monitoring.
- Honeypot challenges for testing against common web vulnerabilities.


##  Step-by-Step Guide to Setup the Environment

### 2.1 Prerequisites

Before you begin, make sure you have the following prerequisites in place:

- A server with a suitable operating system (e.g.debien).
- Nginx  installed and configured.
- PHP 8.2 installed and configured.
- mariadb intalled on the server
- Elasticsearch, Kibana, and filebeat set up for  logging.



### 2.2 Configuring Nginx

- Set up Nginx to serve your web application.

- Create server blocks or virtual hosts for your web application and configure them to use SSL (HTTPS).

- Ensure that your web application is accessible over HTTPS for secure communication.



### 2.3 Web Environment Setup

## 2.3.1 Implementing User Authentication and Registration

- Implement user authentication for secure login.

- Set up user registration without email verification, captcha, or 2FA.


## 2.3.2 User Account Management and Avatars

- Create an admin panel for user management, including the ability to enable/disable users.

- Allow users to upload avatars and handle them securely.


## 2.3.3 Kibana Integration for Logging
 
- Set up Elasticsearch, Kibana, and filebeat to collect and analyze logs.

- Configure log shipping from your web server and honeypot to Elasticsearch.


## 2.3.4 Honeypot Challenges

- Create honeypot challenges within your web environment to test for common web vulnerabilities like SQL injection SQL injection, Cross-Site Scripting (XSS), CSRF and Broken Access Control.


## 2.3.5 Honeypot Challenges solution

# CHALLENGE 1(SQL)
        when user inputs are directly inserted into SQL queries without proper sanitization.


#       SOLUTION
   - ' OR 1=1 --
   - ' UNION SELECT null, username, password FROM users --


# CHALLENGE 2(XSS)
   - Here,the PHP script takes a search query from the user through a GET parameter and displays the search results on the page. However, the script directly echoes the user's input without proper escaping or validation, making it vulnerable to XSS attacks.


#      SOLUTION
   - Add this <script>alert("group4");</script>


# CHALLENGE 3(Broken Access Control)

#     SOLUTION

-  Changing the userid cookie to 1 solves the challenge




# CHALLENGE 4(CSRF)
      

#     SOLUTION
    
   - Attacker can create a simple HTML page with JavaScript to perform a CSRF attack . This script will automatically submit a form to transfer funds when the user visits the page.
   
   - lacks anti-CSRF protection. This makes it vulnerable to Cross-Site Request Forgery (CSRF) attacks. 

# CHALLENGE 5(XSS)
     
#    SOLUTION
  
  -  The attacker can access  by modifying the URL in the browser address bar.
   ?input=<img%20src=x%20onerror=alert(group4)>



### 2.4 Securing the Environment

- Implement 'server_tokens off' preventing NGINX from including the server version  information in the HTTP response headers

- Implement 'limit_except'  restricts all HTTP methods except for GET and POST, 

- Inplenevt the 'autoindex directive'NGINX won't automatically generate a directory listing. Instead, it will typically return a "403 Forbidden" error or whatever error page you have configured for such cases. 

- Implement 'The add_header directive'This header is a security feature that helps protect your website against clickjacking attacks


- Regularly update your server and scripts to address security vulnerabilities.



### 2.5 Monitoring and Analysis

## Custom Log Directory for Nginx Challenges:

- Add a customized log directory for the challenges in the Nginx configuration, you can follow these steps:

- Edit your Nginx configuration file, typically located at /etc/nginx/nginx.conf/default.conf 

- Inside the server block, add  the location block for the challenges and specify a custom log file and directory. For example:


 location /challenges.php {

     access_log /var/log/nginx/html.local.challenges.php.access.log;
     error_log /var/log/nginx/html.local.challenges.php.error.log;
}

- Restart Nginx to apply the changes:
  # sudo service nginx restart

- Regular Review of Logs:
 # tail -f /var/log/nginx/access.log



### 3 Dashboard and Visualization Diagrams from Elasticsearch

# A pie Diagram for request method and response status
![Alt text](Images/pie_requestandresponse.png)
# A Heat map Diagram for request method and response status
![Alt text](Heatmap_requestandresponse.png)

# A Bar stacked Diagram for IP
![Alt text](barstached_IP.png)

# A Heat map Diagram for IP
![Alt text](heatmap_IP.png)

# A Donut Diagram for IP
![Alt text](donut_IP.png)

#  Diagram for every fields
![Alt text](every_fields.png)

# Date in Discovery
![Alt text](data_discovery.png)





### 3.4 Logging and Analysis // TOBE DONE

- Use Kibana to create detailed dashboards and visualizations for monitoring and analyzing logs effectively.







### 4. Troubleshooting

If you encounter issues during the setup or operation of your honeypot and web environment, consider the following troubleshooting steps:

## 1. Nginx Troubleshooting

# 1.1 Check Nginx Service Status (Verify the status of the Nginx service. Look for error messages or warnings in the output.)

     # sudo systemctl status nginx


#  If Nginx is not running, start the service and check the status again.
     
     # sudo systemctl start nginx


#  Tail the Nginx error log for real-time updates. Look for any error messages or warnings.
    
     # sudo tail -f /var/log/nginx/error.log


#   If you make changes to the Nginx configuration, restart the service to apply the changes.
     
     #  sudo systemctl restart nginx

#  Check your Nginx configuration files for syntax errors. Use the following command to test the configuration:

       # nginx -t

## 2. System Log 
  
  #  Review System Journal (Logs) Use journalctl to review system logs specific to the Nginx service. Look for error messages or warnings.

      # journalctl -u nginx



#   Check for System-Wide Issues (Examine the entire system journal for potential issues:)
    
    #  journalctl







## 5. Conclusion

By following this guide, you will able to  successfully set up a honeypot and a secure web environment. Regularly monitor and analyze logs, adapt your security measures.




STAY SECURE! 



