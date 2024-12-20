package my.ipleiria.playxchange;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.widget.GridView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.util.ArrayList;

import my.ipleiria.playxchange.adapters.JogosAdapter;
import my.ipleiria.playxchange.listeners.JogosListener;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class InteracaoJogosActivity extends AppCompatActivity implements JogosListener {

    GridView gvJogos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_interacao_jogos);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        Bundle extras = getIntent().getExtras(); // Obter os parametros passados para esta activity, neste caso será desejados / favoritos / jogados
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }
        if (extras != null) {
            gvJogos = findViewById(R.id.gvJogos);
            SingletonLoja.getInstance(getApplicationContext()).setJogosListener(this);
            int code = extras.getInt("request_code");
            handleInteracao(code);
        }else {
            Toast.makeText(this, "Não foi possível encontrar o tipo de interação especificado", Toast.LENGTH_SHORT).show();
            finish();
        }
    }

    private void handleInteracao(int code) {
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        switch (code) {
            case Constants.REQUEST_CODE_PLAYED:
                SingletonLoja.getInstance(getApplicationContext()).getJogadosAPI(getApplicationContext(),token);
                break;
            case Constants.REQUEST_CODE_WISHLIST:
                SingletonLoja.getInstance(getApplicationContext()).getDesejadosAPI(getApplicationContext(),token);
                break;
            case Constants.REQUEST_CODE_FAVORITES:
                SingletonLoja.getInstance(getApplicationContext()).getFavoritosAPI(getApplicationContext(),token);
                break;
            default:
                Toast.makeText(this, "Não foi possível encontrar o tipo de interação especificado", Toast.LENGTH_SHORT).show();
                finish();
        }
    }

    @Override
    public void onRefreshListaJogos(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosRecentes(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosPopulares(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosFavoritos(ArrayList<Jogo> jogos) {
        this.setTitle("Favoritos");
        setAdapter(jogos);
    }

    @Override
    public void onRefreshListaJogosJogados(ArrayList<Jogo> jogos) {
        this.setTitle("Jogados");
        setAdapter(jogos);
    }

    @Override
    public void onRefreshListaJogosDesejados(ArrayList<Jogo> jogos) {
        this.setTitle("Desejados");
        setAdapter(jogos);
    }

    private void openGameDetails(int id) {
        Intent intent = new Intent(getApplicationContext(), GameDetailsActivity.class);
        intent.putExtra("ID_JOGO", id);
        startActivity(intent);
    }

    private void setAdapter(ArrayList<Jogo> jogos) {
        JogosAdapter adapter = new JogosAdapter(jogos, getApplicationContext());
        gvJogos.setAdapter(adapter);
        gvJogos.setOnItemClickListener((parent, view, position, id) -> {
            Jogo jogo = jogos.get(position);
            openGameDetails(jogo.getId());
        });
    }
}