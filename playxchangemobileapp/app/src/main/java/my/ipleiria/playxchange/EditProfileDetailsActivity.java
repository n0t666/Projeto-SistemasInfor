package my.ipleiria.playxchange;

import static java.security.AccessController.getContext;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.google.android.material.datepicker.MaterialDatePicker;
import com.google.android.material.datepicker.MaterialPickerOnPositiveButtonClickListener;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textfield.TextInputEditText;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.sql.Time;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.TimeZone;

import my.ipleiria.playxchange.listeners.UserListener;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.models.User;
import my.ipleiria.playxchange.utils.Constants;
import my.ipleiria.playxchange.utils.Rules;

public class EditProfileDetailsActivity extends AppCompatActivity implements UserListener {

    private ImageView ivCapa;
    private ShapeableImageView ivPfp;
    private String capaImage, pfpImage;
    TextInputEditText txtUsername, txtEmail, txtPassword, txtConfirmPassword, txtNome, txtNif, txtBiografia, txtDataNascimento;

    private final int PICK_CAPA_IMAGE_REQUEST = 1;
    private final int PICK_PFP_IMAGE_REQUEST = 2;

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.edit_profile_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (item.getItemId() == android.R.id.home) {
            onBackPressed();
            return true;
        }

        if (id == R.id.ac_save) {
            guardar();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        finish();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_edit_profile_details);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        SharedPreferences sharedPreferences = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).setUserListener(this);
        SingletonLoja.getInstance(getApplicationContext()).getProfileAPI(getApplicationContext(), token);
        ivCapa = findViewById(R.id.ivCapa);
        ivPfp = findViewById(R.id.ivPfp);
        txtUsername = findViewById(R.id.txtUsername);
        txtEmail = findViewById(R.id.txtEmail);
        txtNome = findViewById(R.id.txtNome);
        txtNif = findViewById(R.id.txtNif);
        txtBiografia = findViewById(R.id.txtBio);
        txtDataNascimento = findViewById(R.id.txtDataNascimento);
        txtPassword = findViewById(R.id.txtPassword);
        txtConfirmPassword = findViewById(R.id.txtConfirmarPassword);
        this.setTitle("Editar Perfil");
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }
    }

    @Override
    public void onProfileLoaded(User user) {
        if (user != null) {
            Glide.with(this)
                    .load(user.getImagemCapa())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
            Glide.with(this)
                    .load(user.getImagemPerfil())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivPfp);
            txtBiografia.setText(user.getBiografia());
            txtDataNascimento.setText(user.getDataNascimento());
            txtEmail.setText(user.getEmail());
            txtNif.setText(user.getNif());
            txtUsername.setText(user.getUsername());
            txtNome.setText(user.getNome());
        } else {
            this.finish();
        }


    }

    @Override
    public void onProfileUpdated() {
        View current = getCurrentFocus();
        if (current != null) current.clearFocus(); // Remover o foco no campo que o utilizador está a escrever
        txtPassword.setText("");
        txtConfirmPassword.setText("");
        Toast.makeText(this, "Perfil atualizado com sucesso", Toast.LENGTH_SHORT).show();
    }

    public void onUploadCapaButtonClick(View view) {
        escolherImagem(PICK_CAPA_IMAGE_REQUEST);
    }

    public void onUploadPfpButtonClick(View view) {
        escolherImagem(PICK_PFP_IMAGE_REQUEST);
    }

    private void escolherImagem(int requestCode) {
        Intent imagePickerIntent = new Intent(Intent.ACTION_OPEN_DOCUMENT); // Abrir o explorador de ficheiros de modo a evitar problemas com permissões
        imagePickerIntent.setType("image/*"); // Apenas permitir a escolha de imagens
        imagePickerIntent.putExtra("outputFormat", Bitmap.CompressFormat.JPEG.toString()); // Definir o formato da imagem
        startActivityForResult(imagePickerIntent, requestCode); // Iniciar a atividade de escolha de imagem com base no código que indica se é para a capa ou para a imagem de perfil
    }

    /*
     * Função adaptada de: https://stackoverflow.com/questions/39703655/how-to-upload-image-on-server-using-volley
     */

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == RESULT_OK && data != null) {
            Uri filePath = data.getData();
            try {
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(getContentResolver(), filePath);
                if (requestCode == PICK_CAPA_IMAGE_REQUEST) {
                    updateVisualImage(bitmap, ivCapa, true);
                } else if (requestCode == PICK_PFP_IMAGE_REQUEST) {
                    updateVisualImage(bitmap, ivPfp, false);
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    private void updateVisualImage(Bitmap bitmap, ImageView imageView, boolean isCapa) {
        Bitmap bt = bitmap;
        if (isCapa) {
            capaImage = getStringImage(bitmap);
        } else {
            pfpImage = getStringImage(bitmap);
        }
        imageView.setImageBitmap(bt);
    }

    public String getStringImage(Bitmap bmp) {
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        bmp.compress(Bitmap.CompressFormat.JPEG, 100, baos);
        byte[] imageBytes = baos.toByteArray();
        return Base64.encodeToString(imageBytes, Base64.DEFAULT);
    }

    public void onDataNascimentoClick(View view) {
        Toast.makeText(this, "AAA", Toast.LENGTH_SHORT).show();
        MaterialDatePicker datePicker = MaterialDatePicker.Builder.datePicker()
                .setInputMode(MaterialDatePicker.INPUT_MODE_CALENDAR)
                .setSelection(MaterialDatePicker.todayInUtcMilliseconds())
                .setTitleText("Selecione a data de nascimento")
                .build();
        datePicker.show(getSupportFragmentManager(), "DATE_PICKER");
        datePicker.addOnPositiveButtonClickListener(new MaterialPickerOnPositiveButtonClickListener() {


            @Override
            public void onPositiveButtonClick(Object selection) {
                try {
                    Long date = (Long) selection; // Obter a data selecionada
                    Calendar calendar = Calendar.getInstance(TimeZone.getTimeZone("UTC")); // Obter a data atual
                    calendar.setTimeInMillis(date);
                    SimpleDateFormat dateFormat = new SimpleDateFormat("dd-MM-yyyy"); // Formatar a data para o formato Dia-Mês-Ano
                    txtDataNascimento.setText(dateFormat.format(calendar.getTime()));
                } catch (Exception e) {
                    Toast.makeText(getApplicationContext(), "Erro ao selecionar a data de nascimento", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    private void guardar() {
        if (validateInputs()) {
            SharedPreferences sharedPreferences = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
            String token = sharedPreferences.getString(Constants.TOKEN, null);
            SingletonLoja.getInstance(getApplicationContext()).setUserListener(this);
            try {
                JSONObject mainObj = new JSONObject();
                JSONObject userObj = new JSONObject();
                JSONObject profileObj = new JSONObject();
                userObj.put("username", txtUsername.getText().toString());
                userObj.put("email", txtEmail.getText().toString());
                userObj.put("password", txtPassword.getText().toString());
                profileObj.put("nome", txtNome.getText().toString());
                profileObj.put("nif", txtNif.getText().toString());
                profileObj.put("biografia", txtBiografia.getText().toString());
                profileObj.put("dataNascimento", txtDataNascimento.getText().toString());
                if (capaImage != null) {
                    profileObj.put("imagemCapa", capaImage);
                }
                if (pfpImage != null) {
                    profileObj.put("imagemPerfil", pfpImage);
                }
                mainObj.put("profile", profileObj);
                mainObj.put("user", userObj);
                Log.d("JSON", mainObj.toString());
                SingletonLoja.getInstance(getApplicationContext()).updateUser(getApplicationContext(),token, mainObj);
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        } else {
            Toast.makeText(this, "Erro ao guardar", Toast.LENGTH_SHORT).show();
        }
    }

    private boolean validateInputs(){
        if(!Rules.isUsernameValid(txtUsername.getText().toString())){
            txtUsername.setError("O username tem de ter pelo menos " + Constants.MIN_USERNAME_LENGTH + " caracteres");
            return false;
        }
        if(txtNome.getText().toString().isEmpty()){
            txtNome.setError("O nome não pode estar vazio");
            return false;
        }else if (!Rules.isNomeValid(txtNome.getText().toString())){
            txtNome.setError("O nome não pode ter mais de " + Constants.MAX_NAME_LENGTH + " caracteres");
            return false;
        }

        if(!Rules.isEmailValid(txtEmail.getText().toString())){
            txtEmail.setError("Email inválido");
            return false;
        }

        if(!Rules.isNifValid(txtNif.getText().toString())){
            txtNif.setError("O NIF tem de ter " + Constants.NIF_LENGTH + " dígitos numéricos");
            return false;
        }

        if(!Rules.isBiografiaValid(txtBiografia.getText().toString())){
            txtBiografia.setError("A biografia não pode ter mais de " + Constants.MAX_BIO_LENGTH + " caracteres");
            return false;
        }

        if(!txtPassword.getText().toString().isEmpty()) {
            if (!Rules.isPasswordValid(txtPassword.getText().toString())) {
                txtPassword.setError("A password tem de ter pelo menos " + Constants.MIN_PASSWORD_LENGTH + " caracteres");
                return false;
            }
            if(!txtPassword.getText().toString().equals(txtConfirmPassword.getText().toString())) {
                txtConfirmPassword.setError("As passwords têm de ser iguais");
                return false;
            }
        }
        return true;
    }


}