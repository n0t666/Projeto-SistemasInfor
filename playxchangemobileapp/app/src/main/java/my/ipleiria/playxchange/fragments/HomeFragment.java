package my.ipleiria.playxchange.fragments;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Response;

import java.util.ArrayList;

import my.ipleiria.playxchange.GameDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.CarouselAdapterJogos;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.SingletonLoja;

public class HomeFragment extends Fragment {

    private RecyclerView rvPopular, rvRecent;

    private CarouselAdapterJogos popularCarouselAdapter,recentCarouselAdapter;

    private ArrayList<Jogo> popularJogos = new ArrayList<>();
    private ArrayList<Jogo> recentJogos = new ArrayList<>();


    public HomeFragment() {

    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_home, container, false);

        rvPopular = view.findViewById(R.id.rvPopular);
        rvRecent = view.findViewById(R.id.rvRecent);

        popularCarouselAdapter = new CarouselAdapterJogos(getContext(), popularJogos);
        recentCarouselAdapter = new CarouselAdapterJogos(getContext(), recentJogos);

        popularCarouselAdapter.setOnItemClickListener(new CarouselAdapterJogos.OnItemClickListener() {
            @Override
            public void onClick(ImageView imageView, Jogo jogo) {
                openGameDetails(jogo);
            }
        });

        recentCarouselAdapter.setOnItemClickListener(new CarouselAdapterJogos.OnItemClickListener() {
            @Override
            public void onClick(ImageView imageView, Jogo jogo) {
                openGameDetails(jogo);
            }
        });

        rvPopular.setAdapter(popularCarouselAdapter);
        rvRecent.setAdapter(recentCarouselAdapter);

        getJogos();


        return view;
    }

    private void getJogos() {
        SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(), "populares", new Response.Listener<ArrayList<Jogo>>() {
            @Override
            public void onResponse(ArrayList<Jogo> jogos) {
                popularJogos.clear();
                popularJogos.addAll(jogos);
                popularCarouselAdapter.notifyDataSetChanged();
            }
        });



        SingletonLoja.getInstance(getContext()).getJogosByCategoriaAPI(getContext(), "recentes", new Response.Listener<ArrayList<Jogo>>() {
            @Override
            public void onResponse(ArrayList<Jogo> jogos) {
                recentJogos.clear();
                recentJogos.addAll(jogos);
                recentCarouselAdapter.notifyDataSetChanged();
            }
        });
    }

    private void openGameDetails(Jogo jogo) {
        Intent intent = new Intent(getContext(), GameDetailsActivity.class);
        intent.putExtra("ID_JOGO", jogo.getId());
        startActivity(intent);
    }


}