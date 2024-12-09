package my.ipleiria.playxchange;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.view.ContextThemeWrapper;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Response;
import com.bumptech.glide.Glide;
import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;

import java.util.ArrayList;

import my.ipleiria.playxchange.adapters.CarouselAdapterJogos;
import my.ipleiria.playxchange.adapters.CarouselAdapterScreenshots;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.PlataformaItem;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class GameDetailsActivity extends AppCompatActivity {

    private TextView tvTitle,tvReleaseDate,tvPrice,tvQuantity,tvAvg,tvWish,tvPlayed,tvReviews,tvEditora,tvDistribuidora,tvDescricao;
    private Button btnCart;
    private Jogo lJogo;
    private ImageView ivCapa;
    private AutoCompleteTextView dpPlataforma;
    private PlataformaItem selectedPlataforma;
    private ChipGroup chGroupTags;
    private RecyclerView rvScreenshots;
    private CarouselAdapterScreenshots carouselAdapterScreenshots;

    private static final int MAX_QUANTITY = 10;
    private static final int MIN_QUANTITY = 1;

    private int selectedProdutoId = -1;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_game_details);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            int id = extras.getInt("ID_JOGO");
            getJogo(id);
        }else {
            Toast.makeText(this, "Não foi possível encontrar o jogo especificado", Toast.LENGTH_SHORT).show();
        }
        tvTitle = findViewById(R.id.tvTitle);
        tvReleaseDate = findViewById(R.id.tvReleaseDate);
        tvPrice = findViewById(R.id.tvPrice);
        tvQuantity = findViewById(R.id.tvQuantity);
        tvAvg = findViewById(R.id.tvAvg);
        tvWish = findViewById(R.id.tvWish);
        tvPlayed = findViewById(R.id.tvPlayed);
        tvReviews = findViewById(R.id.tvReviews);
        tvEditora = findViewById(R.id.tvEditoraText);
        tvDistribuidora = findViewById(R.id.tvPublicadoraText);
        tvDescricao = findViewById(R.id.tvDescricaoText);
        btnCart = findViewById(R.id.btnCart);
        ivCapa = findViewById(R.id.ivCapa);
        dpPlataforma = findViewById(R.id.dpPlataforma);
        chGroupTags = findViewById(R.id.chGroupTags);
        rvScreenshots = findViewById(R.id.rvScreenshotsCarousel);
    }

    public void getJogo(int id) {
        SingletonLoja.getInstance(getApplicationContext()).findJogoByIdAPI(getApplicationContext(), id, new Response.Listener<Jogo>() {
            @Override
            public void onResponse(Jogo jogo) {
                if (jogo != null) {
                    lJogo = jogo;
                    setJogo();
                } else {
                    Toast.makeText(GameDetailsActivity.this, "Detalhes do jogo não encontrados", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    private void setJogo(){
        if(lJogo != null){
            tvTitle.setText(lJogo.getNome());
            tvReleaseDate.setText(lJogo.getDataLancamento());
            tvAvg.setText(String.valueOf(lJogo.getMedia())); ;
            tvWish.setText(String.valueOf(lJogo.getDesejados()));
            tvPlayed.setText(String.valueOf(lJogo.getJogados()));
            tvReviews.setText(String.valueOf(lJogo.getReviews()));
            tvEditora.setText(lJogo.getEditora());
            tvDistribuidora.setText(lJogo.getDistribuidora());
            tvDescricao.setText(lJogo.getDescricao());
            setTags();
            setScreenshots();
            ArrayList<PlataformaItem> produtoNames = new ArrayList<>();
            for(Jogo.Produto produto : lJogo.getProdutos()){ // Necessário criar um classe PlatformItem para poder adicionar ao dropdown e ao selecionar obter o id e procurar
                produtoNames.add(new PlataformaItem(produto.getPlataformaNome(), produto.getId()));
            }
            setPlataformaDropdown(produtoNames);
            Glide.with(getApplicationContext())
                    .load(lJogo.getCapas())
                    .placeholder(R.drawable.placeholder_jogo)
                    .into(ivCapa);
        }
    }

    public void tvTrailerOnClick(View view){
        if(lJogo != null){
            startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse(lJogo.getTrailer())));
        }
    }

    public void setPlataformaDropdown(ArrayList<PlataformaItem> plataformas){
        ArrayAdapter<PlataformaItem> adapter = new ArrayAdapter<>(this, android.R.layout.simple_dropdown_item_1line, plataformas);
        dpPlataforma.setAdapter(adapter);
        dpPlataforma.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Jogo.Produto selectedProduto = lJogo.getProdutos().get(position); // Procurar o produto pelo seu id na lista de produtos do jogo
                selectedProdutoId = selectedProduto.getId();
                tvPrice.setText(String.format("%.2f€", selectedProduto.getPreco())); // Mostrar o preço da plataforma selecionada
            }
        });
    }

    public void btnCartOnClick(View view){
        int quantity = Integer.parseInt(tvQuantity.getText().toString());
        if(selectedProdutoId == -1){
            Toast.makeText(this, "Selecione uma plataforma antes de adicionar ao carrinho", Toast.LENGTH_SHORT).show();
            return;
        }
        if(quantity >= MIN_QUANTITY && quantity <= MAX_QUANTITY ) {
            saveCart(selectedProdutoId, quantity);
        }else {
            Toast.makeText(this, "Quantidade inválida", Toast.LENGTH_SHORT).show();
            return;
        }
    }

    public void incrementOnClick(View view){
        if(lJogo != null){
            int quantity = Integer.parseInt(tvQuantity.getText().toString());
            if(quantity < MAX_QUANTITY){
                tvQuantity.setText(String.valueOf(quantity + 1));
            }
        }
    }

    public void decrementOnClick(View view){
        if(lJogo != null){
            int quantity = Integer.parseInt(tvQuantity.getText().toString());
            if(quantity > MIN_QUANTITY){
                tvQuantity.setText(String.valueOf(quantity - 1));
            }
        }
    }

    private void saveCart(int produtoId, int quantidade){
        SharedPreferences sharedPreferences = getApplicationContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        SingletonLoja.getInstance(getApplicationContext()).addProdutoCarrinho(getApplicationContext(), produtoId, quantidade, sharedPreferences.getString(Constants.TOKEN,""), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Toast.makeText(getApplicationContext(), "Produto adicionado ao carrinho", Toast.LENGTH_SHORT).show();

            }
        });
    }

    private void setTags(){
        if(lJogo != null){
            for(Jogo.Tag tag : lJogo.getTags()){
                Chip chip = new Chip(new ContextThemeWrapper(this, R.style.TagChip));
                chip.setText(tag.getNome());
                chGroupTags.addView(chip);
            }
        }
    }

    private void setScreenshots(){
        if(lJogo != null){
            if(!lJogo.getScreenshots().isEmpty()){
                carouselAdapterScreenshots = new CarouselAdapterScreenshots(getApplicationContext(), lJogo.getScreenshots());
                rvScreenshots.setAdapter(carouselAdapterScreenshots);
                carouselAdapterScreenshots.notifyDataSetChanged();
            }
        }
    }


}