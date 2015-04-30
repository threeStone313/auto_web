package com.netease.qa.testng;

import java.awt.Graphics;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Set;

import javax.imageio.ImageIO;

import org.apache.commons.io.FileUtils;
import org.apache.log4j.Logger;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.testng.ITestContext;
import org.testng.ITestResult;
import org.testng.Reporter;
import org.testng.TestListenerAdapter;

/**
 * @author netease_arrow
 * 
 * 
 */
public class TestResultListener extends TestListenerAdapter {

	private static Logger logger = Logger.getLogger(TestResultListener.class.getName());
    protected ITestContext testContext = null; 
	
	@Override
	public void onStart(ITestContext testContext) {   
		this.testContext = testContext;
		super.onStart(testContext);
	}

	@Override
	public void onTestFailure(ITestResult tr) {
		super.onTestFailure(tr);
		logger.error("<font color='red'>"+ tr.getName() + " test case runs failed!</font><br>");
		WebDriver webDriver = (WebDriver) testContext.getAttribute("SELENIUM_DRIVER");  //这里就是取driver
		saveScreenShot(tr,webDriver);
	}

	@Override
	public void onTestSkipped(ITestResult tr) {
		super.onTestSkipped(tr);
		WebDriver webDriver = (WebDriver) testContext.getAttribute("SELENIUM_DRIVER");
		logger.info("<font color='IndianRed '>"+tr.getName() + " test case was skipped</font><br>");	
		saveScreenShot(tr,webDriver);
	
	}

	@Override
	public void onTestSuccess(ITestResult tr) {
		super.onTestSuccess(tr);
		logger.info(tr.getName() + " test case runs successfully<br>");
	}

	@Override
	public void onTestStart(ITestResult tr) {
		super.onTestStart(tr);
		logger.info("<font color='MediumSeaGreen'>"+tr.getName() + " test case start running</font><br>");
	}

	@Override
	public void onFinish(ITestContext testContext) {
		super.onFinish(testContext);

		// List of test results which we will delete later
		ArrayList<ITestResult> testsToBeRemoved = new ArrayList<ITestResult>();
		// collect all id's from passed test
		Set<Integer> passedTestIds = new HashSet<Integer>();
		for (ITestResult passedTest : testContext.getPassedTests().getAllResults()) {
			logger.info("Passed= " + passedTest.getName());
			passedTestIds.add(getId(passedTest));
		}

		// Eliminate the repeat methods
		Set<Integer> skipTestIds = new HashSet<Integer>();
		for (ITestResult skipTest : testContext.getSkippedTests().getAllResults()) {
			logger.info("Skipped = " + skipTest.getName());
			// id = class + method + dataprovider
			int skipTestId = getId(skipTest);

			if (skipTestIds.contains(skipTestId) || passedTestIds.contains(skipTestId)) {
				testsToBeRemoved.add(skipTest);
			} else {
				skipTestIds.add(skipTestId);
			}
		}
		
		// Eliminate the repeat failed methods
		Set<Integer> failedTestIds = new HashSet<Integer>();
		for (ITestResult failedTest : testContext.getFailedTests().getAllResults()) {
			logger.info("Failed = " + failedTest.getName());
			// id = class + method + dataprovider
			int failedTestId = getId(failedTest);

			// if we saw this test as a failed test before we mark as to be
			// deleted
			// or delete this failed test if there is at least one passed
			// version
			if (failedTestIds.contains(failedTestId) || passedTestIds.contains(failedTestId) ||
					skipTestIds.contains(failedTestId)) {
				testsToBeRemoved.add(failedTest);
			} else {
				failedTestIds.add(failedTestId);
			}
		}
		

		

		// finally delete all tests that are marked
		for (Iterator<ITestResult> iterator = testContext.getFailedTests().getAllResults().iterator(); iterator.hasNext();) {
			ITestResult testResult = iterator.next();
			if (testsToBeRemoved.contains(testResult)) {
				logger.info("Removed repeat faild test case = " + testResult.getName()+"<br>");
				iterator.remove();
			}
		}

	}

	private int getId(ITestResult result) {
		int id = result.getTestClass().getName().hashCode();
		id = id + result.getMethod().getMethodName().hashCode();
		id = id + (result.getParameters() != null ? Arrays.hashCode(result.getParameters()) : 0);
		return id;
	}
	 private void saveScreenShot(ITestResult tr,WebDriver driver) {
	        SimpleDateFormat formatter = new SimpleDateFormat("yyyy_MM_dd_HH_mm_ss");
	        String mDateTime = formatter.format(new Date());
	        String fileName = mDateTime + "_" + tr.getName();
	        String filePath = "";
	        try {
	            
	            File screenshot = ((TakesScreenshot)driver).getScreenshotAs(OutputType.FILE);
	            filePath = "result/screenshot/" + fileName + ".jpg";
	            File destFile = new File(filePath);
	            FileUtils.copyFile(screenshot, destFile);
	            logger.info(fileName+"screenshot successfully,saved"+"[ "+filePath+" ]<br>");

	        } catch (Exception e) {
	                filePath = fileName + " ,screenshot failed saved,the reason:" + e.getMessage();
	                logger.error(filePath+"<br>");
	        }

	        if (!"".equals(filePath)) {
	             Reporter.setCurrentTestResult(tr);
	             Reporter.log(filePath);
	             
	            Reporter.log("<img src=\"/" + filePath + "\"/>");
	        }
	 }

	}
//	  private void saveScreenShot(ITestResult tr,WebDriver driver) {
//	        SimpleDateFormat formatter = new SimpleDateFormat("yyyy_MM_dd_HH_mm_ss");
//	        String mDateTime = formatter.format(new Date());
//	        String fileName = mDateTime + "_" + tr.getName();
//	        String filePath = "";
//	        try {
//	            
//	            File screenshot = ((TakesScreenshot)driver).getScreenshotAs(OutputType.FILE);
//	            filePath = "result/screenshot/" + fileName + ".jpg";
//	            File destFile = new File(filePath);
//	            Boolean a=this.narrowAndFormateTransfer(screenshot);
//	            if(a){
//	            FileUtils.copyFile(screenshot, destFile);
//	            logger.info("<font color='red'>"+fileName+"screenshot successfully,saved"+"[ "+filePath+" ]</font><br>");
//	            }
//	        } catch (Exception e) {
//	                filePath = fileName + " ,screenshot failed saved,the reason:" + e.getMessage();
//	                logger.error("<font color='red'>"+filePath+"</font><br>");
//	        }
//
//	        if (!"".equals(filePath)) {
//	             Reporter.setCurrentTestResult(tr);
//	             Reporter.log(filePath);
//	             
//	             Reporter.log("<img src=\"../../" + filePath + "\"/>");
//	        }
//	 }
//	    public Boolean narrowAndFormateTransfer(File srcfile) {
//	    	Boolean flag = null;
//	        try {
//	            BufferedImage src = ImageIO.read(srcfile); 
//	            int wide=src.getWidth();
//	            int high=src.getHeight();
//	           // Image image = src.getScaledInstance(width, height, Image.SCALE_DEFAULT);
//	            BufferedImage  tag = new BufferedImage(wide/2, high/2, BufferedImage.TYPE_INT_RGB);
//	            Graphics g = tag.getGraphics();
//	            g.drawImage(src,0,0, wide/2, high/2, null); 
//	            g.dispose();
//	          flag = ImageIO.write(tag, "JPG", new FileOutputStream(srcfile));
//	        } catch (IOException e) {
//	            e.printStackTrace();
//	        }
//	        return flag;
//	    }

	//}