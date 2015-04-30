package KWS.prepare;

import java.io.FileInputStream;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

import org.openqa.selenium.By;
import org.testng.Assert;







public class testdata extends basePrepare {
	static FileInputStream filePath;
	static String caseid;
	static int stepid=0;
	static Statement statement;
	static PreparedStatement pstate;
	static ResultSet rs = null ;
	static String[] actions_arr ={"","GoToUrl","Click","Type","RightClick","Pause","SwicthWindow","SwitchIframe","ReturnToMainFrame","Select","Mouseover","ExecuteJS","ExecuteSqls","VerifyTextPresent","VerifyUrl","VerifRegUrl","VerifyElementPresent","VerifyElementNotPresent","Referenced steps pack"};
	static Connection conn ;
	static String[] locator_arr={"","id","classname","name","xpath","eleRepository"};
	static ArrayList<Integer> idList = new ArrayList<Integer>();
	 public static void readExcel(String caseid ) throws IOException, SQLException{
		 testdata.caseid=caseid;
	  	String driver = "com.mysql.jdbc.Driver";
	  	String url = "jdbc:mysql://localhost/ci_test";
	  	String user = "root";
	  	String password = "";
	  	try {
			Class.forName(driver);
		} catch (ClassNotFoundException e1) {
			e1.printStackTrace();
		}
	  	conn = DriverManager.getConnection(url, user, password);
	  	statement = conn.createStatement();
	  	pstate=conn.prepareStatement("select * from `ci_pack_step` where pack_id=? order by `orderby` asc");
	  	try {
 
		String data=null;
		String ele=null;
		String locator=null;
		int time=0;
		int l_num=0;
		int a_num=0;
		

		ResultSet ru;
		ResultSet le;
	try {


		String sql="select * from `ci_case_step` where cid ="+caseid+" order by `orderby` asc";

		ru = statement.executeQuery(sql);
		while(ru.next()){	
			int pack_id = ru.getInt("pack_id");			
			a_num = ru.getInt("action");
			String a = actions_arr[a_num]; 
			int step_id=0;

			switch(a){
			case "GoToUrl":
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.getUrl(data);
				break;
			case "Type":				
				data=ru.getString("data").replaceAll("\"", "\'");

				l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.getElement(getlocator(locator,ele,step_id)).sendKeys(data);
				autoMan.sleep(1000);
				break;
			case "Click":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.getElement(getlocator(locator,ele,step_id)).click();
				break;
			case "Pause":
				time=Integer.valueOf(ru.getString("data"));
				autoMan.sleep(time);
				break;
			case "Mouseover":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.moveToElement(getlocator(locator,ele,step_id));
				break;
			case "Select":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.selectByVisibleText(getlocator(locator,ele,step_id), data);
				break;
			case "RightClick":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.rightClick(getlocator(locator,ele,step_id));
				break;
			case "SwicthWindow":
				int window=ru.getInt("data");
				autoMan.switchWindow(window);
				break;
			case "SwitchIframe":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.swicthToFrame(getlocator(locator,ele,step_id));
				break;
			case "ReturnToMainFrame":
				autoMan.returnToFrame();
				break;
			case "ExecuteJS":
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.JSexecute(data);
				break;
			case "ExecuteSqls":
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.SqlsOperation(sqlUrl,sqlAccount,sqlPassword,data);
				break;
			case "VerifyTextPresent":
				data=ru.getString("data").replaceAll("\"", "\'");
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				String b=autoMan.getElement(getlocator(locator,ele,step_id)).getText().replaceAll("\"", "\'");
				autoMan.textEquals(data,b);
				break;
			case "VerifyElementNotPresent":
				 l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.falseEquals(getlocator(locator,ele,step_id));
				break;
			case "VerifyUrl":
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.UrlEquals(data);
				break;
			case "VerifRegUrl":
				data=ru.getString("data").replaceAll("\"", "\'");
				autoMan.partOfUrlEquals(data);
				break;
			case "VerifyElementPresent":
				l_num = ru.getInt("locator");
				locator = locator_arr[l_num];
				step_id = ru.getInt("id");
				ele=ru.getString("element");
				autoMan.ElementPresent(getlocator(locator,ele,step_id));
				break;
			case "Referenced steps pack":
		 		String locate = null;
		 		String element = null;
		 		String ac=null;
		 		String shuju=null;
				String name=ru.getString("data");
				
				pstate.setInt(1, pack_id);
				le=pstate.executeQuery();
				
				while(le.next()){
					a_num =le.getInt("action");
					ac = actions_arr[a_num];
	    			switch(ac){
		    			case "GoToUrl":
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				autoMan.getUrl(shuju);
		    				break;
		    			case "Type":				
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.getElement(getlocator(locate,element,1)).sendKeys(shuju);
		    				autoMan.sleep(1000);
		    				break;
		    			case "Click":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.getElement(getlocator(locate,element,1)).click();
		    				break;
		    			case "Pause":
		    				time=Integer.valueOf(le.getString("data"));
		    				autoMan.sleep(time);
		    				break;
		    			case "Mouseover":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.moveToElement(getlocator(locate,element,1));
		    				break;
		    			case "Select":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				autoMan.selectByVisibleText(getlocator(locate,element,1), shuju);
		    				break;
		    			case "RightClick":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.rightClick(getlocator(locate,element,1));
		    				break;
		    			case "SwicthWindow":
		    				int window2=le.getInt("data");
		    				autoMan.switchWindow(window2);
		    				break;
		    			case "SwitchIframe":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.swicthToFrame(getlocator(locate,element,1));
		    				break;
		    			case "ReturnToMainFrame":
		    				autoMan.returnToFrame();
		    				break;
		    			case "ExecuteJS":
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				autoMan.JSexecute(shuju);
		    				break;
		    			case "ExecuteSqls":
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				autoMan.SqlsOperation(sqlUrl,sqlAccount,sqlPassword,shuju);
		    				break;
		    			case "VerifyTextPresent":
		    				shuju=le.getString("data").replaceAll("\"", "\'");
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				String c=autoMan.getElement(getlocator(locate,element,1)).getText().replaceAll("\"", "\'");
		    				autoMan.textEquals(shuju,c);
		    				break;
		    			case "VerifyElementNotPresen":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.falseEquals(getlocator(locate,element,1));
		    			case "VerifyUrl":
		    				shuju=ru.getString("data").replaceAll("\"", "\'");
		    				autoMan.UrlEquals(shuju);
		    				break;
		    			case "VerifRegUrl":
		    				shuju=ru.getString("data").replaceAll("\"", "\'");
		    				autoMan.partOfUrlEquals(shuju);
		    				break;
		    			case "VerifyElementPresent":
		    				l_num = le.getInt("locator");
		    				locate=locator_arr[l_num];
		    				element=le.getString("element");
		    				autoMan.ElementPresent(getlocator(locate,element,1));
		    				break;
		    		}
				}
				break;
			}		
		}
	} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			//Assert.fail("step"+idList.get(i)+"错误");
		}
}catch(Exception e) {
		e.printStackTrace();
		} 
  	conn.close();
}
	   

	
	
	 public static By getlocator(String locatorWay,String ele, int step_id) throws IOException, SQLException{
		 By locator=null;
		 	if(locatorWay.equalsIgnoreCase("xpath")){
		 		String elee=ele.replaceAll("\"", "\'");
		 		locator=By.xpath(elee);
		 	}
		 	else if(locatorWay.equalsIgnoreCase("ClassName")){
		 		locator=By.className(ele);
		 	}
		 	else if(locatorWay.equalsIgnoreCase("id")){
		 		locator=By.id(ele);
		 	}
		 	else if(locatorWay.equalsIgnoreCase("LinkText")){
		 		locator=By.linkText(ele);
		 	}
		 	else if(locatorWay.equalsIgnoreCase("Name")){
		 		locator=By.name(ele);
		 	}
		 	else if(locatorWay.equalsIgnoreCase("eleRepository")){
		 		
		 		PreparedStatement pstate2 = conn.prepareStatement("select el.`locator`,el.`element` from ci_ele_repository el left join ci_case_step cs on el.`alias`=cs.`alias` where cs.id=?");
		 		
		 		ResultSet le;
		 		String locate = null;
		 		String element = null;
		 		int l_num=0;
		 		try {
		 			pstate2.setInt(1, step_id);
					le=pstate2.executeQuery( );
					while(le.next()){
			 			l_num = le.getInt("locator");
						locate = locator_arr[l_num];
			    		 element=le.getString("element");
			    			 }
					return getlocator(locate, element, 1);
		 		} catch (SQLException e) {
					e.printStackTrace();
				}
		 		
		    			 
		 	}else{
		 		Assert.fail(""+locatorWay+" wrong");
		 	}
		 	return locator;
		 }
}
