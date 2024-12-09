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
import java.util.List;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Jogo;

public class CarouselAdapterScreenshots extends RecyclerView.Adapter<CarouselAdapterScreenshots.ViewHolder>  {
    Context context;

    List<String> screenshots;
    OnItemClickListener onItemClickListener;

    public CarouselAdapterScreenshots(Context context, List<String> screenshots){
        this.context = context;
        this.screenshots = screenshots;
    }


    @NonNull
    @Override
    public CarouselAdapterScreenshots.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(context).inflate(R.layout.screenshot_carousel_item, parent, false);
        return new ViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(@NonNull CarouselAdapterScreenshots.ViewHolder holder, int position) {
        Glide.with(context)
                .load(screenshots.get(position))
                .placeholder(R.drawable.placeholder_jogo)
                .into(holder.imageView);
    }

    @Override
    public int getItemCount() {
        return  screenshots.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder{
        ImageView imageView;


        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.carousel_image_view);
        }
    }

    public void setOnItemClickListener(CarouselAdapterScreenshots.OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public interface OnItemClickListener {

    }
}
