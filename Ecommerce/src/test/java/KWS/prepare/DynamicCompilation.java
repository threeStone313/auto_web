package KWS.prepare;

import java.io.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Arrays;
import javax.tools.JavaCompiler;
import javax.tools.StandardJavaFileManager;
import javax.tools.StandardLocation;
import javax.tools.ToolProvider;



public class DynamicCompilation {
    static String time;
  public static void main(String[] args) throws Exception {
    // create the source
	  time=args[0];

    File sourceFile   = new File("D:\\xampp\\htdocs\\ci_test\\Ecommerce\\src\\test\\java\\KWS\\prepare\\t"+time+".java");
    sourceFile.createNewFile();
    FileWriter writer = new FileWriter(sourceFile);

    writer.write(
    		"package KWS.prepare; \n"+
    		"import org.testng.annotations.Test; \n"+
    		
    		"import java.io.IOException; \n"+
    		"import java.sql.SQLException;\n"+
            "public class t"+time+" extends basePrepare{ \n" 
    );
    ResultSet re = getCaseName() ;
    int n=0;
    while(re.next()){
    	String name = re.getString("name");
    	String cid=re.getString("cid").toString();
    	//String projectname=re.getString("pname");
    writer.write(
    		"@Test(priority="+n+++") \n" +
    	    " public void"+"   "+name+"() throws IOException,SQLException{ \n" +
    	    "testdata.readExcel(\""+cid+"\");\n" +
    	    " }\n" 
    	    
    		);
    }
    
    writer.write(
    		"}"
    		);
    writer.close();

    // JavaCompiler compiler= ToolProvider.getSystemJavaCompiler();
    // StandardJavaFileManager fileManager =
    //     compiler.getStandardFileManager(null, null, null);

    // fileManager.setLocation(StandardLocation.CLASS_OUTPUT,
    //                         Arrays.asList(new File("D:\\xampp\\htdocs\\ci_test\\Ecommerce\\target\\test-classes\\KWS\\prepare")));
    // // Compile the file
    // compiler.getTask(null,
    //            fileManager,
    //            null,
    //            null,
    //            null,
    //            fileManager.getJavaFileObjectsFromFiles(Arrays.asList(sourceFile)))
    //         .call();
    // fileManager.close();


    // delete the source file
    // sourceFile.deleteOnExit();

//       runIt();
  }

  	public static ResultSet getCaseName(){
  		ResultSet rs = null ;
  		String driver = "com.mysql.jdbc.Driver";
  	String url = "jdbc:mysql://localhost/ci_test";
  	String user = "root";
  	String password = "";
  	try {
  	Class.forName(driver);
  	Connection conn = DriverManager.getConnection(url, user, password);
  	Statement statement = conn.createStatement();
//  		String path="D:\\ST\\keywords";
//  		String name="";
//  		ArrayList names=new ArrayList();
//	  // get file list where the path has   
//  		File file = new File(path);   
//      // get the folder list   
//  		File[] array = file.listFiles();
//  		for(File a : array){
//  			if (a.isFile()){
//  				name=a.getName().substring(0, a.getName().lastIndexOf("."));
//  				if(! name.equals("eleRepository")){
//  					names.add(name);
//  				}
//    	 }
//      
//  }
//	return names;
      String sql="select e.cid,c.cname name from `ci_execute` e left join `ci_case` c on c.id=e.cid where e.filename ='"+time+"' order by c.orderby asc";
  		//String sql="select id,name,pname from test_cases where id in (select case_id from `ci_execute` where 'filename'="+time+" ) and pname in (select pname from "+time+") order by id";
  		rs = statement.executeQuery(sql);
//  		String name="";
//  		
//  		while(rs.next()){
//  			name=rs.getString("name");s
//  			names.add(name);
//  		}
  		}catch(ClassNotFoundException e) {
  			System.out.println("Sorry,can`t find the Driver!");
  			e.printStackTrace();
  			} catch(SQLException e) {
  			e.printStackTrace();
  			} catch(Exception e) {
  			e.printStackTrace();
  			}
  		return rs;
  	
  	}
}




