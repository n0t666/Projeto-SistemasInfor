package my.ipleiria.playxchange;

import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.view.ContextThemeWrapper;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.content.res.AppCompatResources;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Response;
import com.bumptech.glide.Glide;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.bottomsheet.BottomSheetDialog;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;

import java.util.ArrayList;

import my.ipleiria.playxchange.adapters.CarouselAdapterScreenshots;
import my.ipleiria.playxchange.models.Avaliacao;
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

    private BottomSheetDialog bottomSheet;




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
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).findJogoByIdAPI(getApplicationContext(), id,token, new Response.Listener<Jogo>() {
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
        SingletonLoja.getInstance(getApplicationContext()).addProdutoCarrinhoAPI(getApplicationContext(), produtoId, quantidade, sharedPreferences.getString(Constants.TOKEN,""), new Response.Listener<String>() {
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
            }
        }
    }

    public void onClickBottomSheet(View view) {

        if (lJogo != null) {
            BottomSheetDialog bottomSheetDialog = new BottomSheetDialog(this, R.style.BottomSheetDialog);
            bottomSheetDialog.setContentView(R.layout.bottom_sheet_jogos);
            MaterialButton btnPlay = bottomSheetDialog.findViewById(R.id.btnPlay);
            MaterialButton btnFavorite = bottomSheetDialog.findViewById(R.id.btnFavorite);
            MaterialButton btnWishlist = bottomSheetDialog.findViewById(R.id.btnWishlist);
            MaterialButton btnComment = bottomSheetDialog.findViewById(R.id.btnComment);
            TextView tvTitle = bottomSheetDialog.findViewById(R.id.tvTitle);
            TextView tvReleaseDate = bottomSheetDialog.findViewById(R.id.tvReleaseDate);
            RatingBar rbStars = bottomSheetDialog.findViewById(R.id.rbStars);
            MaterialButton btnClearRating = bottomSheetDialog.findViewById(R.id.btnClear);


            if(lJogo.getAvaliacao() != null){
                rbStars.setRating((float) lJogo.getAvaliacao().getNumEstrelas());
            }


            if (lJogo.getAtividade() != null) {
                checkButtonStatus(btnPlay, lJogo.getAtividade().isJogado(), R.drawable.ic_play_circle_filled, R.drawable.ic_play_circle_outline, R.color.highlight_played, R.color.highlight_unplayed);
                checkButtonStatus(btnFavorite, lJogo.getAtividade().isFavorito(), R.drawable.ic_favorite_filled, R.drawable.ic_favorite, R.color.highlight_favorited, R.color.highlight_unfavorited);
                checkButtonStatus(btnWishlist, lJogo.getAtividade().isDesejado(), R.drawable.ic_bookmark, R.drawable.ic_bookmark_border, R.color.highlight_wishlist, R.color.highlight_unwishlist);
            }else{
                lJogo.setAtividade(new Jogo.Atividade(-1,-1,lJogo.getId(),0,0,0));

            }


            if (tvTitle != null) {
                tvTitle.setText(lJogo.getNome());
            }
            if (tvReleaseDate != null) {
                tvReleaseDate.setText(lJogo.getDataLancamento());
            }


            String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);

            if (btnPlay != null && token != null) {
                btnPlay.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        interactionHandler(1,token,bottomSheetDialog);
                    }
                });
            }

            if (btnFavorite != null && token != null) {
                btnFavorite.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        interactionHandler(2,token,bottomSheetDialog);
                    }
                });
            }

            if (btnWishlist != null && token != null) {
                btnWishlist.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        interactionHandler(3,token,bottomSheetDialog);
                    }
                });
            }

            if (btnComment != null && token != null) {
                btnComment.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                    }
                });
            }

            if(rbStars!=null && token != null){
                rbStars.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
                    @Override
                    public void onRatingChanged(RatingBar ratingBar, float rating, boolean fromUser) {
                        if(fromUser){
                            if(lJogo.getAvaliacao() == null){
                                if(rating > 0 && rating <= 5){
                                    lJogo.setAvaliacao(new Avaliacao(lJogo.getId(),-1,rating,null)); // É preciso criar uma nova , se no caso for apagado senão irá dar erro
                                    SingletonLoja.getInstance(getApplicationContext()).addAvaliacaoAPI(getApplicationContext(), lJogo.getId(), rating, token, new Response.Listener<String>() {
                                        @Override
                                        public void onResponse(String response) {
                                            lJogo.getAvaliacao().setNumEstrelas(rating);
                                            Toast.makeText(getApplicationContext(), "Avaliação adicionada", Toast.LENGTH_SHORT).show();
                                        }
                                    });
                                }else {
                                    Toast.makeText(getApplicationContext(), "Avaliação inválida (create)", Toast.LENGTH_SHORT).show();
                                }
                            } else if (lJogo.getAvaliacao().getNumEstrelas() != rating){
                                if(rating > 0 && rating <= 5) {
                                    SingletonLoja.getInstance(getApplicationContext()).updateAvaliacaoAPI(getApplicationContext(), lJogo.getId(), rating, token, new Response.Listener<String>() {
                                        @Override
                                        public void onResponse(String response) {
                                            lJogo.getAvaliacao().setNumEstrelas(rating);
                                            Toast.makeText(getApplicationContext(), "Avaliação atualizada", Toast.LENGTH_SHORT).show();
                                        }
                                    });
                                }else if (rating == 0){
                                    SingletonLoja.getInstance(getApplicationContext()).deleteAvaliacaoAPI(getApplicationContext(), lJogo.getId(), token, new Response.Listener<String>() {
                                        @Override
                                        public void onResponse(String response) {
                                            Toast.makeText(getApplicationContext(), "Avaliação removida", Toast.LENGTH_SHORT).show();
                                        }
                                    });
                                }else {
                                    Toast.makeText(getApplicationContext(), "Avaliação inválida", Toast.LENGTH_SHORT).show();
                                }
                            }
                        }
                    }
                });
            }

            if(btnClearRating!=null && token != null){
                if(lJogo.getAvaliacao() != null){
                    btnClearRating.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            bottomSheetDialog.dismiss();
                            MaterialAlertDialogBuilder builder = new MaterialAlertDialogBuilder(GameDetailsActivity.this, R.style.CustomMaterialAlertDialog);
                            builder.setTitle("Remover Avaliação")
                                    .setMessage("Tem a certeza que deseja remover a sua avaliação?")
                                    .setPositiveButton("Sim", (dialog, which) -> {
                                        SingletonLoja.getInstance(getApplicationContext()).deleteAvaliacaoAPI(getApplicationContext(), lJogo.getId(), token, new Response.Listener<String>() {
                                            @Override
                                            public void onResponse(String response) {
                                                lJogo.setAvaliacao(null);
                                                rbStars.setRating(0);
                                                Toast.makeText(getApplicationContext(), "Avaliação removida", Toast.LENGTH_SHORT).show();
                                            }
                                        });
                                    })
                                    .setNegativeButton("Não", (dialog, which) -> {
                                        dialog.dismiss();
                                    })
                                    .show();

                        }
                    });
                }else{
                    btnClearRating.setVisibility(View.GONE);
                }
            }

            bottomSheetDialog.show();
        }else{
            Toast.makeText(this, "Não foi possível encontrar o jogo especificado", Toast.LENGTH_SHORT).show();
        }
    }

    private void checkButtonStatus(MaterialButton button, int status, int iconActive, int iconInactive, int colorActive, int colorInactive){
        if (button != null) {
            if (status == 1) {
                setButtonAppearence(button, iconActive, colorActive);
            } else if (status == 0) {
                setButtonAppearence(button, iconInactive, colorInactive);
            }
        }
    }

    private void setButtonAppearence(MaterialButton button, int icon, int color){
        button.setIcon(AppCompatResources.getDrawable(this, icon));
        button.setIconTintResource(color);
    }


    /*
     * 1 - Jogado , 2 - Favorito , 3 - Desejado
     */
    private void interactionHandler(int action,String token, BottomSheetDialog bottomSheetDialog)  // Passar o bottomSheetDialog como argumento para evitar ter de passar os 3 botões para alterar a parte visual
    {

        if (token != null && lJogo != null) {
           switch (action){
               case 1:
                   lJogo.getAtividade().setJogado(lJogo.getAtividade().isJogado() == 1 ? 0 : 1);
                   bottomSheetDialog.dismiss();
                   break;
                case 2:
                    lJogo.getAtividade().setFavorito(lJogo.getAtividade().isFavorito() == 1 ? 0 : 1);
                    bottomSheetDialog.dismiss();
                    break;
                case 3:
                    lJogo.getAtividade().setDesejado(lJogo.getAtividade().isDesejado() == 1 ? 0 : 1);
                    bottomSheetDialog.dismiss();
                    break;
               default:
                   Toast.makeText(this, "Ação inválida", Toast.LENGTH_SHORT).show();
           }

            SingletonLoja.getInstance(getApplicationContext()).interactJogoAPI(getApplicationContext(), lJogo.getId(), token, action, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Toast.makeText(getApplicationContext(), "Atividade atualizada", Toast.LENGTH_SHORT).show();
                }
            });

        }else {
            Toast.makeText(this, "Não foi possível efetuar o pedido", Toast.LENGTH_SHORT).show();
        }
    }






}