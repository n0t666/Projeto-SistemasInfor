package my.ipleiria.playxchange;

import static java.security.AccessController.getContext;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ListView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.util.ArrayList;

import my.ipleiria.playxchange.adapters.ComentariosAdapter;
import my.ipleiria.playxchange.adapters.FaturaAdapter;
import my.ipleiria.playxchange.listeners.ComentarioListener;
import my.ipleiria.playxchange.listeners.ComentariosListener;
import my.ipleiria.playxchange.models.Comentario;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class ComentariosActivity extends AppCompatActivity implements ComentariosListener {

    ListView lvComentarios;
    private ConstraintLayout clComentariosVazio;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_comentarios);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        lvComentarios = findViewById(R.id.lvComentarios);
        clComentariosVazio = findViewById(R.id.clComentariosVazio);
        SingletonLoja.getInstance(getApplicationContext()).setComentariosListener(this);
        getComentarios();
        this.setTitle(getString(R.string.txt_comentarios_title));
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }
    }

    @Override
    public void onRefreshComentarios(ArrayList<Comentario> comentarios) {
        if (comentarios == null || comentarios.isEmpty()) {
            clComentariosVazio.setVisibility(ConstraintLayout.VISIBLE);
            lvComentarios.setVisibility(ListView.GONE);
        }else{
            clComentariosVazio.setVisibility(ConstraintLayout.GONE);
            lvComentarios.setVisibility(ListView.VISIBLE);
            ComentariosAdapter adapter = new ComentariosAdapter(this, comentarios);
            lvComentarios.setAdapter(adapter);
        }
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
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onResume(){
        super.onResume();
        getComentarios();
    }

    private void getComentarios(){
        SharedPreferences sharedPreferences = getApplicationContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).getComentariosAPI(getApplicationContext(),token);
    }



}