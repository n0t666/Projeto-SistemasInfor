package my.ipleiria.playxchange;

import android.content.Context;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.google.android.material.textview.MaterialTextView;

import my.ipleiria.playxchange.adapters.LinhasFaturaAdapter;
import my.ipleiria.playxchange.listeners.FaturaListener;
import my.ipleiria.playxchange.models.Fatura;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class FaturaDetailsActivity extends AppCompatActivity implements FaturaListener {

    private Fatura auxFatura;
    private ListView lvLinhas;
    private MaterialTextView tvDesconto,tvSubtotal,tvTotal,tvPagamento,tvEnvio,tvData,tvEstado;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_fatura_details);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            int id = extras.getInt("ID_FATURA");
            getFatura(id);
        }else {
            Toast.makeText(this, R.string.txt_fatura_empty, Toast.LENGTH_SHORT).show();
        }
        lvLinhas = findViewById(R.id.lvLinhas);
        tvDesconto = findViewById(R.id.tvDesconto);
        tvSubtotal = findViewById(R.id.tvSubtotal);
        tvTotal = findViewById(R.id.tvTotal);
        tvPagamento = findViewById(R.id.tvPagamento);
        tvEnvio = findViewById(R.id.tvEnvio);
        tvData = findViewById(R.id.tvData);
        tvEstado = findViewById(R.id.tvEstado);
        this.setTitle(getString(R.string.txt_details_fatura_title));
    }

    private void getFatura(int id) {
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).setFaturaListener(this);
        SingletonLoja.getInstance(getApplicationContext()).getFaturaAPI(getApplicationContext(), token, id);
    }

    @Override
    public void onRefreshFatura(Fatura fatura) {
        if(fatura != null){
            auxFatura = fatura;
            lvLinhas.setAdapter(new LinhasFaturaAdapter(this, auxFatura.getLinhasFatura()));
            tvEstado.append(" " + auxFatura.getEstado());
            tvEstado.setTextColor(getResources().getColor(auxFatura.getEstado().getCor()));
            tvDesconto.append(" " + String.format("%.2f€", auxFatura.getQuantidadeDesconto()));
            tvSubtotal.append(" " + String.format("%.2f€", auxFatura.getTotalSemDesconto()));
            tvTotal.append(" " + String.format("%.2f€", auxFatura.getTotal()));
            tvPagamento.append(" " + auxFatura.getPagamento());
            tvEnvio.append(" " + auxFatura.getEnvio());
            tvData.append(" " + auxFatura.getDataPagamento());
        }else {
            Toast.makeText(this, R.string.txt_fatura_empty, Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onCreateFatura(Fatura fatura) {

    }


    @Override
    public boolean onSupportNavigateUp(){
        finish();
        return true;
    }
}