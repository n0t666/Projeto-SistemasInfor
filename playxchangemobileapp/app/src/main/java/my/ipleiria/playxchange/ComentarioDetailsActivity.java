package my.ipleiria.playxchange;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textfield.TextInputEditText;
import com.google.android.material.textfield.TextInputLayout;
import com.google.android.material.textview.MaterialTextView;

import my.ipleiria.playxchange.listeners.ComentarioListener;
import my.ipleiria.playxchange.listeners.JogoListener;
import my.ipleiria.playxchange.models.Comentario;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;
import my.ipleiria.playxchange.utils.Rules;

public class ComentarioDetailsActivity extends AppCompatActivity implements ComentarioListener, JogoListener {

    private ShapeableImageView ivCapa;
    private MaterialTextView tvTitulo,tvDataLancamento;
    private TextInputEditText txtComentario;
    private MaterialButton btnGuardar;
    private Menu mOptions;
    private TextInputLayout tfComentario;
    private Comentario auxComentario;
    private int currentMode;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_comentario_details);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        ivCapa = findViewById(R.id.ivCapa);
        tvTitulo = findViewById(R.id.tvJogoNome);
        tvDataLancamento = findViewById(R.id.tvDataLancamento);
        txtComentario = findViewById(R.id.txtComentario);
        btnGuardar = findViewById(R.id.btnGuardar);
        tfComentario = findViewById(R.id.tfComentario);
        SingletonLoja.getInstance(getApplicationContext()).setComentarioListener(this);
        SingletonLoja.getInstance(getApplicationContext()).setJogoListener(this);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            int id = extras.getInt("ID_COMENTARIO");
            int request = extras.getInt("REQUEST_CODE");
            switch (request){
                case Constants.REQUEST_CODE_ADD_COMMENT:
                    int jogoId = extras.getInt("ID_JOGO");
                    if(!(jogoId > 0)){
                        finish();
                    }
                    auxComentario = new Comentario(-1,0,"",null);
                    getJogo(jogoId);
                    currentMode = Constants.REQUEST_CODE_ADD_COMMENT;
                    this.setTitle(R.string.txt_add_com);
                    break;
                case Constants.REQUEST_CODE_EDIT_COMMENT:
                    this.setTitle(R.string.txt_com_title);
                    getComentario(id);
                    currentMode = Constants.REQUEST_CODE_EDIT_COMMENT;
                    showMenuItems();
                    break;
                default:
                    finish();
            }
        }else {
            Toast.makeText(this, R.string.txt_error_find_comentario, Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onRefreshComentario(Comentario comentario) {
        auxComentario = comentario;
        if(auxComentario != null){
            tvTitulo.setText(auxComentario.getJogo().getNome());
            tvDataLancamento.setText(auxComentario.getJogo().getDataLancamento());
            txtComentario.setText(auxComentario.getComentario());
            Glide.with(this)
                    .load(auxComentario.getJogo().getCapas())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
        }else{
            this.finish();
        }

    }

    @Override
    public void onComentarioAdded() {
        Toast.makeText(this, R.string.txt_comentario_added, Toast.LENGTH_SHORT).show();
        Intent intent = new Intent(this, ComentariosActivity.class);
        startActivity(intent);
        this.finish();
    }

    @Override
    public void onComentarioRemoved() {
        Toast.makeText(this, R.string.txt_comentario_removed, Toast.LENGTH_SHORT).show();
        this.finish();
    }

    @Override
    public void onComentarioUpdated() {
       toggleEdit(true);
    }

    private void getComentario(int id){
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).getComentarioAPI(getApplicationContext(),token,id);
    }

    private void getJogo(int id){
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).findJogoByIdAPI(getApplicationContext(),id,token);
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        finish();
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();


        if (item.getItemId() == android.R.id.home) {
            onBackPressed();
            return true;
        } else if (item.getItemId() == R.id.ac_edit) {
            toggleEdit(tfComentario.isEnabled());
        }else if (item.getItemId() == R.id.ac_save) {
            saveComentario();
        }else if (item.getItemId() == R.id.ac_delete) {
            deleteComentario();
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        mOptions = menu;
        getMenuInflater().inflate(R.menu.edit_action, menu);

        MenuItem saveItem = menu.findItem(R.id.ac_save);
        MenuItem deleteItem = menu.findItem(R.id.ac_delete);
        MenuItem editItem = menu.findItem(R.id.ac_edit);
        saveItem.setVisible(false);
        deleteItem.setVisible(false);
        editItem.setVisible(false);

        return true;
    }

    private void saveComentario(){
        if(txtComentario.getText().toString().equals(auxComentario.getComentario())){
            return;
        }

        if(txtComentario.getText() != null && !txtComentario.getText().toString().isEmpty()  && Rules.isComentarioValid(txtComentario.getText().toString())){
            String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
            String comentario = txtComentario.getText().toString();
            if(currentMode == Constants.REQUEST_CODE_ADD_COMMENT){
                SingletonLoja.getInstance(getApplicationContext()).addComentarioAPI(getApplicationContext(),token,auxComentario.getJogo().getId(),comentario);
            }else if(currentMode == Constants.REQUEST_CODE_EDIT_COMMENT){
                SingletonLoja.getInstance(getApplicationContext()).updateComentarioAPI(getApplicationContext(),token,auxComentario.getId(),comentario);
            }
        }else{
            txtComentario.setError((getString(R.string.txt_error_comentario_edit)));
            Toast.makeText(this, getString(R.string.txt_com_inv), Toast.LENGTH_SHORT).show();
        }
    }

    private void deleteComentario(){
        MaterialAlertDialogBuilder builder = new MaterialAlertDialogBuilder(ComentarioDetailsActivity.this, R.style.CustomMaterialAlertDialog);
        builder.setTitle(R.string.txt_remover_com)
                .setMessage(R.string.txt_remover_com_conf)
                .setPositiveButton(R.string.txt_yes, (dialog, which) -> {
                    String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
                    SingletonLoja.getInstance(getApplicationContext()).deleteComentarioAPI(getApplicationContext(),token,auxComentario.getId());
                    this.finish();
                })
                .setNegativeButton(R.string.txt_no, (dialog, which) -> {
                    dialog.dismiss();
                })
                .show();
    }

    public void onGuardarClick(View view) {
        saveComentario();
    }

    public void toggleEdit(final boolean enable) {
        MenuItem saveItem = mOptions.findItem(R.id.ac_save);
        MenuItem deleteItem = mOptions.findItem(R.id.ac_delete);
        MenuItem editItem = mOptions.findItem(R.id.ac_edit);
        if(enable) {
            editItem.setIcon(R.drawable.ic_edit_off_24);
            tfComentario.setEnabled(false);
            btnGuardar.setEnabled(false);
            btnGuardar.setVisibility(View.GONE);
            saveItem.setVisible(false);
            deleteItem.setVisible(false);
            editItem.setTitle(R.string.txt_edit);
            this.setTitle(R.string.txt_com_title);
        }else {
            editItem.setIcon(R.drawable.ic_edit_24);
            tfComentario.setEnabled(true);
            btnGuardar.setEnabled(true);
            btnGuardar.setVisibility(View.VISIBLE);
            saveItem.setVisible(true);
            deleteItem.setVisible(true);
            editItem.setTitle(R.string.txt_edit_disable);
            this.setTitle(R.string.txt_edit_com);
        }
    }

    private void showMenuItems() { // Dá trigger para o onPrepareOptionsMenu, para avaliar se deve mostrar os botões
        invalidateOptionsMenu();
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu) {
        if (currentMode == Constants.REQUEST_CODE_EDIT_COMMENT) {
            MenuItem saveItem = menu.findItem(R.id.ac_save);
            MenuItem deleteItem = menu.findItem(R.id.ac_delete);
            MenuItem editItem = menu.findItem(R.id.ac_edit);
            saveItem.setVisible(false);
            deleteItem.setVisible(false);
            editItem.setVisible(true);
        }else if (currentMode == Constants.REQUEST_CODE_ADD_COMMENT) {
            MenuItem saveItem = menu.findItem(R.id.ac_save);
            MenuItem deleteItem = menu.findItem(R.id.ac_delete);
            MenuItem editItem = menu.findItem(R.id.ac_edit);
            saveItem.setVisible(false);
            deleteItem.setVisible(false);
            editItem.setVisible(false);
        }
        return super.onPrepareOptionsMenu(menu);
    }

    @Override
    public void onRefreshJogo(Jogo jogo) {
        if(jogo!=null){
            auxComentario.setJogo(jogo);
            tvTitulo.setText(auxComentario.getJogo().getNome());
            tvDataLancamento.setText(auxComentario.getJogo().getDataLancamento());
            Glide.with(this)
                    .load(auxComentario.getJogo().getCapas())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
            tfComentario.setEnabled(true);
            btnGuardar.setVisibility(View.VISIBLE);
            btnGuardar.setEnabled(true);
        }else{
            this.finish();
        }
    }

    @Override
    public void onAddCarrinho() {

    }

    @Override
    public void onInteract(int action) {

    }

    @Override
    public void onRatingCreated(double numEstrelas) {

    }

    @Override
    public void onRatingChanged(double numEstrelas) {

    }

    @Override
    public void onRatingDeleted() {

    }
}