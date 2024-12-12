package my.ipleiria.playxchange;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.android.volley.Response;
import com.google.android.material.textfield.TextInputEditText;
import com.google.android.material.textfield.TextInputLayout;

import my.ipleiria.playxchange.listeners.LoginListener;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    private TextInputEditText txtUsername,txtPassword;
    private TextInputLayout tvUsername, tvPassword;
    private SharedPreferences sharedPreferences;
    private ImageView ivConfig;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_login);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        txtUsername = findViewById(R.id.txtUsername);
        txtPassword = findViewById(R.id.txtPassword);
        tvUsername = findViewById(R.id.tvUsername);
        tvPassword = findViewById(R.id.tvPassword);
        ivConfig = findViewById(R.id.ivConfig);
        sharedPreferences = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);

        checkLoginStatus();
    }

    public void onClickLogin(View view){
        String username = txtUsername.getText().toString();
        String password = txtPassword.getText().toString();

        if(!isUsernameValid(username)){
            tvUsername.setError("O username deve ter mais de 2 caracteres");
            return;
        }else {
            tvUsername.setError(null);
        }

        if(!isPasswordValid(password)){
            tvPassword.setError("A password deve ter mais de 4 caracteres");
            return;
        }else{
            tvPassword.setError(null);
        }

        login(username, password);
    }

    public void onClickConfig(View view){
        Intent intent = new Intent(getApplicationContext(), ServidorActivity.class);
        startActivity(intent);
    }

    public boolean isUsernameValid(String username){
        if(username==null)
            return false;
        return username.length() > 2;
    }

    public boolean isPasswordValid(String password){
        if(password==null)
            return false;
        return password.length() > 4;
    }

    public void login(String username, String password) {
        SingletonLoja.getInstance(getApplicationContext()).loginAPI(username, password, getApplicationContext());
    }

    private void checkLoginStatus() {
        String token = sharedPreferences.getString(Constants.TOKEN, null);

        if (token != null) {
            Intent intent = new Intent(getApplicationContext(), MainActivity.class);
            startActivity(intent);
            finish();
        }
    }

    @Override
    public void onLoginRefresh(String token) {
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(Constants.TOKEN, token);
        editor.apply();
        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
        startActivity(intent);
    }
}