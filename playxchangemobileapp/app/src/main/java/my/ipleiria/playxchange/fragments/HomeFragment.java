package my.ipleiria.playxchange.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.CarouselAdapter;

public class HomeFragment extends Fragment
{

    private RecyclerView recyclerView;
    private CarouselAdapter carouselAdapter;
    private ArrayList<String> imageUrls;


    public HomeFragment() {
        // Required empty public constructor
    }




    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view =  inflater.inflate(R.layout.fragment_home, container, false);

        recyclerView = view.findViewById(R.id.carousel_jogos_populares);


        imageUrls = new ArrayList<>();

        imageUrls.add("http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/jogos/capas/eMLxwZBk_Dn_RS45U_SFuBK4OH6FrJaQ.jpg");
        imageUrls.add("https://upload.wikimedia.org/wikipedia/en/thumb/b/b1/Portrait_placeholder.png/320px-Portrait_placeholder.png");
        imageUrls.add("https://upload.wikimedia.org/wikipedia/en/thumb/b/b1/Portrait_placeholder.png/320px-Portrait_placeholder.png");

        carouselAdapter = new CarouselAdapter(getContext(), imageUrls);
        carouselAdapter.setOnItemClickListener(new CarouselAdapter.OnItemClickListener() {
            @Override
            public void onClick(ImageView imageView, String url) {
                // Handle item click, e.g., open the image in full screen or navigate
                // For example:
                // Toast.makeText(getContext(), "Image clicked: " + url, Toast.LENGTH_SHORT).show();
            }
        });
        recyclerView.setAdapter(carouselAdapter);

        return view;
    }
}