@echo off
echo -----------------------------------------------------In the initialization,pls wait a minute----------------------------------------------------------
cd D:\xampp\htdocs\autoweb\Ecommerce\src\test\java
java -cp ".;lib/jcommander-1.30.jar;lib/qdox-1.12.1jar;lib/selenium-java-2.45.0.jar;lib/testng-6.8.7.jar;lib/commons-codec-1.5.jar;lib/commons-logging-1.1.jar;lib/dom4j-1.6.1.jar;lib/junit-4.11.jar;lib/log4j-1.2.13.jar;lib/poi-3.10.1-20140818.jar;lib/poi-ooxml-3.10.1-20140818.jar;lib/stax-api-1.0.1.jar;lib/poi/xmlbeans-2.6.0.jar;lib/commons-collections-3.2.1.jar;lib/commons-email-1.3.3.jar;lib/mail-1.4.1.jar;lib/activation-1.1.1.jar;lib/commons-exec-1.1.jar;lib/commons-io-2.4.jar;lib/commons-jxpath-1.3.jar;lib/commons-lang3-3.3.2.jar;lib/httpclient-4.3.4.jar;lib/httpcore-4.3.1.jar;lib/guava-18.0.jar;lib/gson-2.2.4.jar;lib/poi-ooxml-schemas-3.10.1-20140818.jar;lib/selenium-api-2.44.0.jar;lib/selenium-chrome-driver-2.45.0.jar;lib/selenium-remote-driver-2.45.0.jar;lib/selenium-support-2.45.0.jar;lib/arrow-0.1.0.jar;lib/selenium-firefox-driver-2.45.0.jar;/lib/json-20080701.jar;lib/selenium-server-standalone-2.44.0.jar;/lib/mysql-connector-java-5.1.30-bin.jar;lib/mysql-connector-java-5.1.22-bin.jar;" KWS.prepare.DynamicCompilation %1

cd D:\xampp\htdocs\autoweb\Ecommerce\src\test\java\KWS\prepare
javac -cp "D:\xampp\htdocs\autoweb\lib\testng-6.8.7.jar;" -d "D:\xampp\htdocs\autoweb\Ecommerce\target\test-classes" t%1.java

cd D:\xampp\htdocs\autoweb
java -cp ".;Ecommerce/target/test-classes;Ecommerce/target/test-classes/KWS/prepare;lib/commons-email-1.3.3.jar;lib/mail-1.4.1.jar;lib/activation-1.1.1.jar;lib/jcommander-1.30.jar;lib/qdox-1.12.1jar;lib/selenium-java-2.45.0.jar;lib/testng-6.8.7.jar;lib/poi/commons-codec-1.5.jar;lib/poi/commons-logging-1.1.jar;lib/poi/dom4j-1.6.1.jar;lib/poi/junit-4.11.jar;lib/poi/log4j-1.2.13.jar;lib/poi/poi-3.10.1-20140818.jar;lib/poi/poi-ooxml-3.10.1-20140818.jar;lib/poi/stax-api-1.0.1.jar;lib/poi/xmlbeans-2.6.0.jar;lib/poi/sqljdbc4.jar;lib/sel/commons-collections-3.2.1.jar;lib/sel/commons-exec-1.1.jar;lib/sel/commons-io-2.4.jar;lib/sel/commons-jxpath-1.3.jar;lib/sel/commons-lang3-3.3.2.jar;lib/httpclient-4.3.4.jar;lib/httpcore-4.3.1.jar;lib/guava-18.0.jar;lib/gson-2.2.4.jar;lib/poi-ooxml-schemas-3.10.1-20140818.jar;lib/selenium-api-2.44.0.jar;lib/selenium-chrome-driver-2.45.0.jar;lib/selenium-remote-driver-2.45.0.jar;lib/selenium-support-2.45.0.jar;lib/arrow-0.1.0.jar;lib/selenium-firefox-driver-2.45.0.jar;lib/json-20080701.jar;lib/selenium-server-standalone-2.44.0.jar;/ib/mysql-connector-java-5.1.30-bin.jar;lib/mysql-connector-java-5.1.22-bin.jar;"  org.testng.TestNG -d "D:\xampp\htdocs\autoweb\result\test-report" Ecommerce\%1.xml

cd Ecommerce 
del %1.xml; 
cd D:\xampp\htdocs\autoweb\Ecommerce\src\test\java\KWS\prepare
del t%1.java; 
cd D:\xampp\htdocs\autoweb\Ecommerce\target\test-classes\KWS\prepare
del t%1.class; 