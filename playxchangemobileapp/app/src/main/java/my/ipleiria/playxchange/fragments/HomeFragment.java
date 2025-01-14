package my.ipleiria.playxchange.fragments;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Response;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.progressindicator.CircularProgressIndicator;

import java.util.ArrayList;

import my.ipleiria.playxchange.GameDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.CarouselAdapterJogos;
import my.ipleiria.playxchange.listeners.JogosListener;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.SingletonLoja;

public class HomeFragment extends Fragment implements JogosListener {

    private RecyclerView rvPopular, rvRecent;
    private CarouselAdapterJogos popularCarouselAdapter,recentCarouselAdapter;
    private CircularProgressIndicator progressBarPopular, progressBarRecent;
    private ArrayList<Jogo> popularJogos = new ArrayList<>();
    private ArrayList<Jogo> recentJogos = new ArrayList<>();
    private SwipeRefreshLayout srlHome;
    private Button btnCatalogo;


    public HomeFragment() {

    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_home, container, false);
        rvPopular = view.findViewById(R.id.rvPopular);
        rvRecent = view.findViewById(R.id.rvRecent);
        rvPopular.setVisibility(View.GONE);
        rvRecent.setVisibility(View.GONE);
        popularCarouselAdapter = new CarouselAdapterJogos(getContext(), popularJogos);
        recentCarouselAdapter = new CarouselAdapterJogos(getContext(), recentJogos);
        progressBarPopular = view.findViewById(R.id.piPopular);
        progressBarRecent = view.findViewById(R.id.piRecent);
        srlHome = view.findViewById(R.id.srlHome);
        btnCatalogo = view.findViewById(R.id.btnCatalgo);

        progressBarPopular.setVisibility(View.VISIBLE);
        progressBarRecent.setVisibility(View.VISIBLE);


        SingletonLoja.getInstance(getContext()).setJogosListener(this);
        SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(),"populares");
        SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(),"recentes");

        srlHome.setOnRefreshListener(() -> {
            SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(),"populares");
            SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(),"recentes");
            srlHome.setRefreshing(false);
        });

        btnCatalogo.setOnClickListener(v -> {
            BottomNavigationView navigationView = getActivity().findViewById(R.id.bottomNavView);
            navigationView.setSelectedItemId(R.id.games);
        });




        return view;
    }


    private void openGameDetails(Jogo jogo) {
        Intent intent = new Intent(getContext(), GameDetailsActivity.class);
        intent.putExtra("ID_JOGO", jogo.getId());
        startActivity(intent);
    }


    @Override
    public void onRefreshListaJogos(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosRecentes(ArrayList<Jogo> jogos) {
        recentJogos.clear();
        recentJogos.addAll(jogos);
        recentCarouselAdapter = new CarouselAdapterJogos(getContext(), recentJogos);
        recentCarouselAdapter.setOnItemClickListener(new CarouselAdapterJogos.OnItemClickListener() {
            @Override
            public void onClick(ImageView imageView, Jogo jogo) {
                openGameDetails(jogo);
            }
        });
        rvRecent.setAdapter(recentCarouselAdapter);
        progressBarRecent.setVisibility(View.GONE);
        rvRecent.setVisibility(View.VISIBLE);
    }

    @Override
    public void onRefreshListaJogosPopulares(ArrayList<Jogo> jogos) {
        popularJogos.clear();
        popularJogos.addAll(jogos);
        popularCarouselAdapter = new CarouselAdapterJogos(getContext(), popularJogos);
        popularCarouselAdapter.setOnItemClickListener(new CarouselAdapterJogos.OnItemClickListener() {
            @Override
            public void onClick(ImageView imageView, Jogo jogo) {
                openGameDetails(jogo);
            }
        });
        rvPopular.setAdapter(popularCarouselAdapter);
        progressBarPopular.setVisibility(View.GONE);
        rvPopular.setVisibility(View.VISIBLE);
    }

    @Override
    public void onRefreshListaJogosFavoritos(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosJogados(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosDesejados(ArrayList<Jogo> jogos) {

    }
}