package KWS.prepare;

import java.net.MalformedURLException;
import java.net.URL;

import org.apache.commons.mail.EmailException;
import org.apache.log4j.Logger;
import org.openqa.selenium.Dimension;
import org.openqa.selenium.Proxy;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxProfile;
import org.openqa.selenium.remote.CapabilityType;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.testng.ITestContext;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

public class basePrepare {
	public static Logger logger = Logger.getLogger(basePrepare.class.getName());
	public static WebDriver driver = null;
	public ITestContext testContext = null;
	public static String sqlUrl=null;
	public static String sqlAccount=null;
	public static String sqlPassword=null;
	
	// @Parameters({"browser"})

	@BeforeMethod
	public void setBrowser(ITestContext context) throws MalformedURLException {
		this.testContext = context;
		String browser = context.getCurrentXmlTest().getParameter("browser");
		String IP = context.getCurrentXmlTest().getParameter("IP");
		String width=context.getCurrentXmlTest().getParameter("width");
		String height=context.getCurrentXmlTest().getParameter("height");
			sqlUrl = context.getCurrentXmlTest().getParameter("sqlUrl");
		    sqlAccount= context.getCurrentXmlTest().getParameter("sqlAccount");
		    sqlPassword= context.getCurrentXmlTest().getParameter("sqlPassword");
		try {
//			if (browser.equals("firefox")) {				
//				FirefoxProfile profile = new FirefoxProfile(
//						new File(
//								"C:\\Users\\swang\\AppData\\Roaming\\Mozilla\\Firefox\\Profiles\\prm1ngix.default"));
//				driver = new FirefoxDriver(profile);
//			} else if (browser.equals("chrome")) {
//				System.setProperty("webdriver.chrome.driver",
//						"D:\\Selenium\\chromedriver.exe");
//				ChromeOptions options = new ChromeOptions();
//				// options.addExtensions(new
//				// File("C:\\Users\\swang\\AppData\\Local\\Google\\Chrome\\User Data\\Default\\Extensions\\ijaobnmmgonppmablhldddpfmgpklbfh\\1.6.0_0.crx"));
//				options.setBinary("C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe");
//				options.addArguments("test-type", "start-maximized",
//						"no-default-browser-check");
//				driver = new ChromeDriver(options);
//			}
			 if (browser.equals("firefox")) {
//				 FirefoxProfile fp = new FirefoxProfile();
//				 fp.setPreference("network.proxy.type", 1);
//				 fp.setPreference("network.proxy.http", "172.26.0.17");
//				 fp.setPreference("network.proxy.http_port", 3128);
//				 fp.setPreference("network.proxy.ssl", "172.26.0.17");
//				 fp.setPreference("network.proxy.ssl_port", 3128);
//				 fp.setPreference("network.proxy.ftp", "172.26.0.17");
//				 fp.setPreference("network.proxy.ftp_port", 3128);
//				 fp.setPreference("network.proxy.socks", "172.26.0.17");
//				 fp.setPreference("network.proxy.socks_port", 3128);
				DesiredCapabilities dc = DesiredCapabilities.firefox();
//				dc.setCapability(FirefoxDriver.PROFILE, fp);
				driver = new RemoteWebDriver(new URL(
						"http://"+IP+":4444/wd/hub"), dc);
				if(!width.isEmpty()&& !height.isEmpty()){
					driver.manage().window().setSize(new Dimension(Integer.parseInt(width), Integer.parseInt(height)));
					}else{
						driver.manage().window().maximize();
					}
			}else if(browser.equals("chrome")){	
				DesiredCapabilities dc = DesiredCapabilities.chrome();
//				Proxy proxy = new Proxy();
//				String p="172.26.0.17:3128";
//				proxy.setHttpProxy(p).setFtpProxy(p).setSslProxy(p);
//				dc.setCapability(CapabilityType.PROXY,proxy);
				driver = new RemoteWebDriver(new URL(
						"http://"+IP+":4444/wd/hub"), dc);
				if(!width.isEmpty()&& !height.isEmpty()){
				driver.manage().window().setSize(new Dimension(Integer.parseInt(width), Integer.parseInt(height)));
				}else{
					driver.manage().window().maximize();
				}
			}
			logger.info("Luanch [" + browser + "] successfully <br>");
			testContext.setAttribute("SELENIUM_DRIVER", driver);
		} catch (Exception e) {
			logger.error("<font color='IndianRed '>Can't launch [" + browser + "],maybe your ip address is wrong!</font><br>");
		}
		
	}

	@AfterMethod
	public void afterTest() throws EmailException {
		logger.info("Close the browser successfully<br>");
		logger.info("Send the report to your email address.<br>");
		driver.quit();
//		try {
//			Thread.sleep(5000);
//		} catch (InterruptedException e) {
//			// TODO Auto-generated catch block
//			e.printStackTrace();
//		}
//		String emailto=testContext.getCurrentXmlTest().getParameter("email");
//		EmailAttachment attachment = new EmailAttachment();
//		 attachment.setPath("C:\\wamp\\www\\autoWeb\\result\\test-report\\power-emailable-report.html");
//		  attachment.setDisposition(EmailAttachment.ATTACHMENT);
//		  attachment.setDescription("test report");
//		  attachment.setName("test report");
//
//		  // Create the email message
//		  MultiPartEmail email = new MultiPartEmail();
//		  email.setHostName("smtp.googlemail.com");
//		  email.setSmtpPort(465);
//		  email.setAuthentication("swang@xogrp.com", "Wl123456");
//		  email.setSSLOnConnect(true);
//		  email.setFrom("swang@xogrp.com");
//		  email.addTo(emailto);
//		  email.setSubject("Auto test report");
//		  email.setMsg("Here is the test report,please check!");
//
//		  // add the attachment
//		  email.attach(attachment);
//		  	try {
//				Thread.sleep(5000);
//			} catch (InterruptedException e) {
//				// TODO Auto-generated catch block
//				e.printStackTrace();
//			}
//		  // send the email
//		  email.send();

}
}
