package KWS.prepare;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import org.apache.log4j.Logger;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.testng.Assert;
import org.testng.ITestContext;

import KWS.prepare.basePrepare;


public class autoMan{
	public static Logger logger = Logger.getLogger(autoMan.class.getName());
	public static int waitTime = 20;
	public static Actions action;
	public static void getUrl(String url) {
		try{
		basePrepare.driver.get(url);
		sleep(5000);
		logger.info("go to ["+url+"]<br> ");
		}catch(TimeoutException e){
			logger.error("can't load ["+url+"]<br> ");
			Assert.fail("can't load ["+url+"] ");
			
		}
	}

	public static String getCurrentUrl() {
		logger.info("Get current page' url <br>");
		return basePrepare.driver.getCurrentUrl();	
	}

	public static WebElement getElement(final By by) {
		WebElement element = null;
		try {
			boolean status = new WebDriverWait(basePrepare.driver, waitTime)
					.until(new ExpectedCondition<Boolean>() {

						@Override
						public Boolean apply(WebDriver d) {
							return d.findElement(by).isDisplayed();
						}
					});
			if (status) {
				element = basePrepare.driver.findElement(by);
				logger.info("founded the element [" + by + "] and operate it <br>");
			}
		} catch (TimeoutException e) {
			logger.error("TIME OUT!! " + waitTime
					+ " second(s) has passed,but did not find element [" + by
					+ "] <br>");
			Assert.fail("TIME OUT!! " + waitTime
					+ " second(s) has passed,but did not find element [" + by
					+ "] ");
		}
		return element;
	}

	public static WebElement getElementNoWait(final By by) {
		WebElement element = null;
		try {
			element = basePrepare.driver.findElement(by);
			logger.info("founded the element [" + by + "] and operate <br>");
		} catch (Exception e) {
			element = null;
			logger.error("did not find element [" + by + "] <br>");
			Assert.fail("Did not find element [" + by + "] ");
		}
		return element;
	}
	public static WebElement getElements(final By by,final int index){
		WebElement element = null;
		try {
			boolean status = new WebDriverWait(basePrepare.driver, waitTime)
					.until(new ExpectedCondition<Boolean>() {

						@Override
						public Boolean apply(WebDriver d) {
							return d.findElements(by).get(index).isDisplayed();
						}
					});
			if (status) {
			element = basePrepare.driver.findElements(by).get(index);
			logger.info("founded ["+basePrepare.driver.findElements(by).size()+"] ["+by+"] and operate <br>");
		}} catch (TimeoutException e) {
			element = null;
			logger.error("TIME OUT!! " + waitTime
					+ " second(s) has passed,but did not find element [" + by
					+ "] <br>");
			Assert.fail("TIME OUT!! " + waitTime
					+ " second(s) has passed,but did not find element [" + by
					+ "] ");
		}
		return element;
	}
	public static boolean ElementExist (final By by){
		try{
			basePrepare.driver.findElement(by);
			return true;
		}catch(org.openqa.selenium.NoSuchElementException ex){
			return false;
		}
	 }
	public static void sleep(int sleepTime) {
		try {
			Thread.sleep(sleepTime);
			logger.info("Wait ["+sleepTime+"] ms <br>");
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
	public static void swicthToFrame(By by){
		try{
			basePrepare.driver.switchTo().frame(basePrepare.driver.findElement(by));
			logger.info("switch to iframe ["+by+"] <br>");			
		}catch(Exception e){
		logger.error("Can not switch to iframe <br>");
		Assert.fail("Can not switch to iframe ["+by+"] ");
	}
	}
	public static void returnToFrame(){
		try{
				basePrepare.driver.switchTo().defaultContent();
				logger.info("switch to defaultContent <br>");
		}catch(Exception e){
			logger.info("Can not return to main frame <br>");
			Assert.fail("Can not return to main frame ");
	}
	}
	public  static void selectByVisibleText(final By by, String text) {
		try {
			Select select = new Select(getElement(by));
			select.selectByVisibleText(text);
			logger.info("The element [" + text + "] is selected <br>");
		} catch (Exception e) {
			logger.error("did not find element [" + by +"]["+text+"] <br>");
			Assert.fail("did not find element [" + by +"]["+text+"] ");
		}
	}
	public  static void moveToElement(final By by){
		try{
		action=new Actions(basePrepare.driver);
		action.moveToElement(getElement(by)).perform();
		logger.info("Found element [" + by + "] and hold on it <br>");
		}catch(Exception e){
			logger.info("did not find element [" + by +"] <br>");
			Assert.fail("did not find element [" + by +"] ");
		}
	}
	public  static void rightClick(final By by){
		try{
		action=new Actions(basePrepare.driver);
		action.moveToElement(getElement(by)).contextClick().perform();
		logger.info("Found element [" + by + "] and rightClick it <br>");
		}catch(Exception e){
			logger.info("can not rightClick [" + by +"] <br>");
			Assert.fail("can not rightClick [" + by +"]  ");
	}
	}
	public static void switchWindow(int a) {
		try {
			String[] handles = new String[basePrepare.driver.getWindowHandles()
					.size()];
			basePrepare.driver.getWindowHandles().toArray(handles);
			basePrepare.driver.switchTo().window(handles[a]);
				logger.info("Focused on ["+a+"] window <br>");
		} catch (Exception e) {
			logger.error("Can not jump to ["+a+"] window] <br>");
			Assert.fail("Can not jump to ["+a+"] window] ");
		}
	}
	public static void waitUntilConfirm(final By by){
		new WebDriverWait(basePrepare.driver, 120).until(new ExpectedCondition<Boolean>(){

			@Override
			public Boolean apply(WebDriver d) {
				return d.findElement(by).isDisplayed();
			}	
		});
		
	}
	public static boolean isTextPresent(String tagName ,String what) {
			boolean a=basePrepare.driver.findElement(By.tagName(tagName)).getText().contains(what);
			if(a){
			logger.info("this tagName contains ["+what+"] <br>");
			}else{
				logger.info("this tagName didn't contains ["+what+"] <br>");
			}
			return a;
		}

	public static void SqlsOperation(String sqlUrl,String sqlAccount,String sqlPassword,String ...sql) throws SQLException {
		 String driver = "com.microsoft.sqlserver.jdbc.SQLServerDriver";
		  String URL = "jdbc:sqlserver://"+sqlUrl+";user="+sqlAccount+";password="+sqlPassword;
		  Connection con = null;
		  Statement st = null;
		  try
		  {
		   Class.forName(driver);
		   logger.info("connect to DB success <br>");
		  }
		  catch(java.lang.ClassNotFoundException e)
		  {
		   
		   logger.error(e.getException());
		   Assert.fail(driver, e.getException());
		  }
		  
		  
		   con = DriverManager.getConnection(URL);
		   st = con.createStatement();
		   for(int i=0;i<sql.length;i++){
			   st.execute(sql[i]);
			   logger.info("exec "+sql[i]);
		   }
		
		   con.close();
		   st.close();   
		 
			
	
	}

	
	public static String executeJS(boolean js,String idorjs){
		String D=null;
		if(js==false){
			String jss="document.getElementById('"+idorjs+"').removeAttribute('readonly')";
		    String js1="return document.getElementById('"+idorjs+"').value";
		    ((JavascriptExecutor)basePrepare.driver).executeScript(jss);
		     D=(String)((JavascriptExecutor)basePrepare.driver).executeScript(js1);
		}else if(js==true){
		    D=(String)((JavascriptExecutor)basePrepare.driver).executeScript(idorjs);
		}
		    return D;
	}
	public static void JSexecute(String ...js){
		for(int i=0;i<js.length;i++){
		((JavascriptExecutor)basePrepare.driver).executeScript(js[i]);
		logger.info("execute ["+js[i]+"] <br>");
		}
	}
	public static void UrlEquals(String a){
		sleep(5000);
		String b=getCurrentUrl();
		logger.info("Expected ["+a+"] and founded ["+b+"] <br>");
		 Assert.assertEquals(b, a);
	}
	public static void partOfUrlEquals(String a){
		sleep(5000);
		String b=getCurrentUrl();
		logger.info("Expected ["+a+"] and founded ["+b+"] <br>");
		Assert.assertTrue(b.matches(a));
	}
	public static void textEquals(String a,String b){
		logger.info("Expected ["+a+"] and founded ["+b+"] <br>");
		Assert.assertEquals(b, a);;
	}
	public static void trueEquals(final By by ){
		boolean b=getElement(by).isDisplayed();
		logger.info("Expected [true] and founded ["+b+"] <br>");
		Assert.assertEquals(b,true);
	}
	public static void falseEquals(final By by ){
		logger.info("Expected [false] and founded ["+ElementExist(by)+"] <br>");
		Assert.assertEquals(ElementExist(by),false);
	}
	public static void attributeEquals(String a,String b){
		logger.info("Expected ["+a+"] and founded ["+b+"] <br>");
		Assert.assertEquals(b,a);
	}
	public static void numberEquals(int a,int b){
		logger.info("Expected ["+a+"] and founded ["+b+"] <br>");
		Assert.assertEquals(b,a);
	}
	public static void ElementPresent(final By by){
		boolean b=getElement(by).isDisplayed();
		logger.info("Expected [true] and founded ["+b+"] <br>");
		Assert.assertEquals(b,true);
	}
}
