package faxingcenter;

import java.io.InputStream;
import java.io.StringWriter;
import java.util.Date;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;
import net.sf.json.JSONSerializer;

import org.apache.commons.io.IOUtils;

import com.sun.jersey.api.client.Client;
import com.sun.jersey.api.client.ClientResponse;
import com.sun.jersey.api.client.WebResource;
import com.sun.jersey.core.util.MultivaluedMapImpl;

/**
 * 
 * @author richardc
 * @Description Use this class as an example for making calls to faxcenter
 *              restful api using java. the example consists of three tests:
 *              send, status and search. For ease of use the results from the
 *              send test are used as input to following status request to
 *              ensure valid output is returned. the search test uses input from
 *              the status test for the same reasons. The class ust have valid
 *              oauth2 credentials supplied for access to the faxcenter server.
 *              Enter these in the static variables at the front of the class.
 * 
 */
public class FaxingCenterExample {

	private static final String FAXCENTER_CLIENTID = "88949ed7fe7a48afbe43e953f2b4f15a";
	private static final String FAXCENTER_CLIENT_SECRET = "d3ab5a643e54476da14fd6a0cebbbdb2";
	private static final String FAXCENTER_AUTHENTICATION_SERVER = "https://api.faxingcenter.com/oauth";

	public static void main(String[] args) {
		try {

			System.out.println("Starting "
					+ FaxingCenterExample.class.getName() + "\n");
			System.out.println("Start Time: " + new Date() + "\n");

			/*
			 * retrieve access token using faxcenter supplied credentials...
			 * Must return a valid access token to be used in the following
			 * three tests.
			 */

			String accessToken = OAuth2Utils.getAccessToken(
					FAXCENTER_AUTHENTICATION_SERVER, FAXCENTER_CLIENTID,
					FAXCENTER_CLIENT_SECRET);

			if (OAuth2Utils.isValid(accessToken)) {
				System.out
						.println("Access token retrieved using faxcenter supplied credentials was: "
								+ accessToken + "\n");
			}

			String appKey = "Bearer " + accessToken;

			Client client = Client.create();

			/*
			 * send fax example...
			 */

			WebResource webResource = client
					.resource("https://api.faxingcenter.com/api/rest/fax/send");

			// load json resuest from resource file...
			InputStream sendFax = FaxingCenterExample.class.getClassLoader()
					.getResourceAsStream("test.send");
			StringWriter writer = new StringWriter();
			IOUtils.copy(sendFax, writer, null);
			String js = writer.toString();

			ClientResponse response = webResource.accept("application/json")
					.type("application/json").header("Authorization", appKey)
					.post(ClientResponse.class, js);

			String jsonStr = response.getEntity(String.class);
			System.out.println("Output from Server after send request.... \n");
			System.out.println(jsonStr + "\n");

			/*
			 * status example... use sid created from send fax example as
			 * input...
			 */

			JSONObject json = (JSONObject) JSONSerializer.toJSON(jsonStr);
			String sid = json.getString("sid");

			webResource = client
					.resource("https://api.faxingcenter.com/api/rest/fax/status");

			MultivaluedMapImpl queryParams = new MultivaluedMapImpl();
			queryParams.add("sid", sid);

			response = webResource.queryParams(queryParams)
					.type("application/json").header("Authorization", appKey)
					.get(ClientResponse.class);

			jsonStr = response.getEntity(String.class);
			System.out
					.println("Output from Server after status request .... \n");
			System.out.println(jsonStr + "\n");

			/*
			 * search example... use data from status request as input...
			 */

			json = (JSONObject) JSONSerializer.toJSON(jsonStr);
			JSONArray results = (JSONArray) json.get("results");
			json = results.getJSONObject(0);
			String from_date = json.getString("sent_on");
			String to_date = json.getString("sent_on");
			String fax = json.getString("fax_number");
			String status = json.getString("status");

			webResource = client
					.resource("https://api.faxingcenter.com/api/rest/fax/search");

			queryParams = new MultivaluedMapImpl();
			queryParams.add("from_date", from_date);
			queryParams.add("to_date", to_date);
			queryParams.add("fax_number", fax);
			queryParams.add("status", status);

			response = webResource.queryParams(queryParams)
					.type("application/json").header("Authorization", appKey)
					.get(ClientResponse.class);

			jsonStr = response.getEntity(String.class);
			System.out
					.println("Output from Server after search request.... \n");
			System.out.println(jsonStr + "\n");

			System.out.println("End Time: " + new Date());

		} catch (Exception e) {

			e.printStackTrace();

		}

	}

}
