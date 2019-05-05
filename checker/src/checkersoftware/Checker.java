/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package checkersoftware;

import com.mashape.unirest.http.HttpResponse;
import com.mashape.unirest.http.JsonNode;
import com.mashape.unirest.http.Unirest;
import com.mashape.unirest.http.exceptions.UnirestException;
import java.awt.Desktop;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URI;
import java.net.URISyntaxException;
import javax.swing.JOptionPane;

/**
 *
 * @author Hengky Surya
 */
public class Checker {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws URISyntaxException{
        // TODO code application logic here
        try{
            String command64 = "powershell.exe Get-Package * | foreach { $_.Name }";

            String outputData = "";
            // Executing the command
            Process powerShellProcess64 = Runtime.getRuntime().exec(command64);
            // Getting the results
            powerShellProcess64.getOutputStream().close();
            String line;
            BufferedReader out64 = new BufferedReader(new InputStreamReader(
              powerShellProcess64.getInputStream()));
            while ((line = out64.readLine()) != null) {
                outputData += line + "\n";
            }
            sendDataToServer(outputData);
            out64.close();
            BufferedReader outError64 = new BufferedReader(new InputStreamReader(
              powerShellProcess64.getErrorStream()));
            if(outError64.readLine() != null){
                System.out.println("There is an error. "+outError64.readLine());
            }
            System.out.println("Program execution done");
        }
        catch(IOException e){
        }
     }

    private static void sendDataToServer(String outputData) throws MalformedURLException, URISyntaxException, IOException {
        String processedData1 = outputData.replaceAll(" ", "");
        String processedData2 = processedData1.replaceAll("\n", "");
        try{
            HttpResponse<JsonNode> jsonResponse = Unirest.post(BuildConfig.SERVER_URL)
                    .header("accept", "application/json")
                    .field("data_software", processedData2)
                    .asJson();
            if(jsonResponse.getBody().getObject().get("status").toString().contains("Berhasil")){
                URI uri = new URI(jsonResponse.getBody().getObject().get("uniq_link").toString());
                Desktop.getDesktop().browse(uri);
                JOptionPane.showMessageDialog(null, "Data software anda berhasil dicatat. Membuka browser...");
            }
            else{
                JOptionPane.showMessageDialog(null, "Terjadi kesalahan, silahkan coba kembali");
            }
            //TODO get JSON data
        }
        catch(UnirestException e){
            e.printStackTrace();
        }
//        Desktop.getDesktop().browse(new URI(BuildConfig.SERVER_URL+BuildConfig.PARAMETER+processedData2));
    }
}
