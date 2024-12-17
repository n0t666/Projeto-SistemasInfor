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

public class ServerActivity extends AppCompatActivity {

    private EditText etIp;
    private SharedPreferences sharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_server);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        etIp = findViewById(R.id.etIp);
        sharedPreferences = getApplicationContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        Constants.IP_ADDRESS = sharedPreferences.getString(Constants.IP_ADDRESS, "");
        if(Constants.IP_ADDRESS.equals("IP_ADDRESS") || Constants.IP_ADDRESS.isEmpty()){
            etIp.setText("");
        }else{
            etIp.setText(Constants.IP_ADDRESS);
        }
        this.setTitle("Configuração do servidor");
    }

    public void onClickServidor(View view){
        SharedPreferences.Editor editor = sharedPreferences.edit();
        String oldIp = sharedPreferences.getString(Constants.IP_ADDRESS, "");
        String newIp = etIp.getText().toString().trim();
        if(validateIp(newIp, oldIp) ){
            Constants.IP_ADDRESS = newIp;
            editor.putString(Constants.IP_ADDRESS, newIp);
            editor.apply();
            Snackbar.make(view, "IP alterado com sucesso", Snackbar.LENGTH_LONG).show();
        }else {
            Snackbar.make(view, "IP inválido", Snackbar.LENGTH_LONG).show();
        }
    }

    public boolean validateIp(String newIp, String oldIp){
        return !newIp.isEmpty() && !newIp.equals(oldIp) && isValidIp(newIp);
    }

    private boolean isValidIp(String ip)
    {
        Pattern ipPattern = Pattern.compile("(\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}):(\\d{1,5})");
        Matcher matcher = ipPattern.matcher(ip);

        if(matcher.find()){
            return true;
        }else{
            Snackbar.make(findViewById(android.R.id.content), "O endereço ip deve seguir a estrutura 1.1.1.1:1", Snackbar.LENGTH_LONG).show();
        }

        return false;
    }
}