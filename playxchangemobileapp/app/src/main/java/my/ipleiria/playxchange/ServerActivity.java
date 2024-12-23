package my.ipleiria.playxchange;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.MenuItem;
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
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }
        etIp = findViewById(R.id.etIp);
        sharedPreferences = getApplicationContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        Constants.IP_ADDRESS = sharedPreferences.getString(Constants.IP_ADDRESS, "");
        etIp.setText(Constants.IP_ADDRESS);
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
        return ip != null && !ip.isEmpty();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                // Handle the back button (Up button)
                onBackPressed();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}