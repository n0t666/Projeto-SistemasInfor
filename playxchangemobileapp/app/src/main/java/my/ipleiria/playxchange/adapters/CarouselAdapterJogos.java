package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;

import java.util.ArrayList;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.utils.Constants;

public class CarouselAdapterJogos extends RecyclerView.Adapter<CarouselAdapterJogos.ViewHolder> {
    Context context;

    ArrayList<Jogo> jogos;
    OnItemClickListener onItemClickListener;

    public CarouselAdapterJogos(Context context, ArrayList<Jogo> jogos){
        this.context = context;
        this.jogos = jogos;
    }

    @NonNull
    @Override
    public CarouselAdapterJogos.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.carousel_item,parent,false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Jogo jogo = jogos.get(position);
        Glide.with(context).load(jogo.getCapas()).into(holder.imageView);

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener.onClick(holder.imageView, jogo);
            }
        });
    }

    @Override
    public int getItemCount() {
        return jogos.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder{
        ImageView imageView;


        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.carousel_image_view);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public interface OnItemClickListener {
        void onClick(ImageView imageView, Jogo jogo);
    }

}
