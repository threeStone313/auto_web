package KWS.prepare; 
import org.testng.annotations.Test; 
import java.io.IOException; 
import java.sql.SQLException;
public class t15042904274521 extends basePrepare{ 
@Test(priority=0) 
 public void   TK_UBVR_AddManualRegistry() throws IOException,SQLException{ 
testdata.readExcel("1");
 }
}