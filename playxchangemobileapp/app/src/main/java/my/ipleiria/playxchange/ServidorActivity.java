package my.ipleiria.playxchange;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.google.android.material.snackbar.Snackbar;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

import my.ipleiria.playxchange.utils.Constants;

public class ServidorActivity extends AppCompatActivity {

    private EditText etIp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_servidor);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        etIp = findViewById(R.id.etIp);
        etIp.setText(Constants.IP_ADDRESS);
    }

    public void onClickServidor(View view){
        SharedPreferences sharedPreferences = getApplicationContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        String oldIp = sharedPreferences.getString(Constants.IP_ADDRESS, "");
        String newIp = etIp.getText().toString().trim();
        if(validateIp(newIp, oldIp) ){
            Constants.IP_ADDRESS = newIp;
            editor.putString(Constants.IP_ADDRESS, newIp);
            editor.apply();
            Snackbar.make(view, "IP alterado com sucesso", Snackbar.LENGTH_SHORT).show();
        }else {
            Snackbar.make(view, "IP inválido", Snackbar.LENGTH_SHORT).show();
        }
    }

    public boolean validateIp(String newIp, String oldIp){
        return !newIp.isEmpty() && !newIp.equals(oldIp) && isValidIp(newIp);
    }

    private boolean isValidIp(String ip) {
        /*
        String ipPattern =  "^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):(\\d{1,5})$";
        Pattern pattern = Pattern.compile(ipPattern);
        Matcher matcher = pattern.matcher(ip);
        if (matcher.matches()) {
            int port = Integer.parseInt(matcher.group(4));
            return port >= 1 && port <= 65535;
        }
        return false;
         */
        String ipPattern = "^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$";
        Pattern pattern = Pattern.compile(ipPattern);
        Matcher matcher = pattern.matcher(ip);
        if (matcher.matches()) {
            return true;
        }
        return false;
    }
}