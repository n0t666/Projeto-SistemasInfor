package my.ipleiria.playxchange.fragments;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textview.MaterialTextView;

import my.ipleiria.playxchange.EditProfileDetailsActivity;
import my.ipleiria.playxchange.LoginActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.ServerActivity;
import my.ipleiria.playxchange.listeners.UserListener;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.models.User;
import my.ipleiria.playxchange.utils.Constants;


public class PerfilFragment extends Fragment implements UserListener {



    private ImageView ivCapa;
    private ShapeableImageView ivPfp;
    MaterialTextView tvUsername,tvBio, tvSeguidoresNum, tvSeguidosNum, tvJogadosNum, tvFavoritosNum,tvReviewsNum,tvDesejadosNum;
    ImageView[] ivFavoritos = {null, null, null, null};

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
    }
    public PerfilFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);
        View view = inflater.inflate(R.layout.fragment_perfil, container, false);
        SingletonLoja.getInstance(getContext()).setUserListener(this);
        SingletonLoja.getInstance(getContext()).getProfileAPI(getContext(),token);
        ivCapa = view.findViewById(R.id.ivCapa);
        ivPfp = view.findViewById(R.id.ivPfp);
        tvUsername = view.findViewById(R.id.tvUsername);
        tvBio = view.findViewById(R.id.tvBio);
        tvSeguidoresNum = view.findViewById(R.id.tvSeguidoresNum);
        tvSeguidosNum = view.findViewById(R.id.tvSeguidosNum);
        ivFavoritos[0] = view.findViewById(R.id.ivFavorito1);
        ivFavoritos[1] = view.findViewById(R.id.ivFavorito2);
        ivFavoritos[2] = view.findViewById(R.id.ivFavorito3);
        ivFavoritos[3] = view.findViewById(R.id.ivFavorito4);
        tvJogadosNum = view.findViewById(R.id.tvJogadosNumber);
        tvFavoritosNum = view.findViewById(R.id.tvFavoritosNumber);
        tvReviewsNum = view.findViewById(R.id.tvReviewsNumber);
        tvDesejadosNum = view.findViewById(R.id.tvDesejadosNumber);

        requireActivity().setTitle("");
        return view;
    }

    @Override
    public void onProfileLoaded(User user) {
        tvUsername.setText(user.getUsername());
        tvBio.setText(user.getBiografia());
        tvSeguidoresNum.setText(String.valueOf(user.getSeguidores()));
        tvSeguidosNum.setText(String.valueOf(user.getSeguidos()));
        Glide.with(this)
                .load(user.getImagemCapa())
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(ivCapa);
        Glide.with(this)
                .load(user.getImagemPerfil())
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(ivPfp);
        for(int i = 0; i < 4; i++) {
            if (i < user.getFavoritosPreview().size()) {
                ivFavoritos[i].setVisibility(View.VISIBLE);
                Glide.with(this).load(user.getFavoritosPreview().get(i).getCapas()).into(ivFavoritos[i]);
            } else {
                ivFavoritos[i].setVisibility(View.GONE);
            }
        }
        tvJogadosNum.setText(String.valueOf(user.getJogosJogados()));
        tvFavoritosNum.setText(String.valueOf(user.getJogosFavoritos()));
        tvReviewsNum.setText(String.valueOf(user.getNumReviews()));
        tvDesejadosNum.setText(String.valueOf(user.getJogosDesejados()));
    }

    @Override
    public void onProfileUpdated() {

    }

    public void openSettings() {
        Intent intent = new Intent(getContext(), ServerActivity.class);
        startActivity(intent);
    }

    public void openEditProfile() {
        Intent intent = new Intent(getContext(), EditProfileDetailsActivity.class);
        startActivity(intent);
    }

    public void logout() {
        SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.clear();
        editor.putString(Constants.IP_ADDRESS, Constants.PROTOCOL + Constants.DEFAULT_IP + Constants.PROJECT);
        editor.apply();
        Intent intent = new Intent(getContext(), LoginActivity.class);
        startActivity(intent);
        if(getActivity() != null) {
            getActivity().finish();
        }

    }

    @Override
    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater menuInflater) {
        super.onCreateOptionsMenu(menu, menuInflater);
        // Inflate the menu specifically for this fragment
        menuInflater.inflate(R.menu.profile_menu, menu);
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem menuItem) {
        if (menuItem.getItemId() == R.id.ac_settings) {
            openSettings();
            return true;
        } else if (menuItem.getItemId() == R.id.ac_edit) {
            openEditProfile();
            return true;
        }else if (menuItem.getItemId() == R.id.ac_logout) {
            logout();
            return true;
        }
        return false;
    }
}